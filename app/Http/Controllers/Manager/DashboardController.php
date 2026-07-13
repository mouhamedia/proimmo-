<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Vue globale du gestionnaire
    public function index()
    {
        // dd('CONTROLEUR MANAGER DASHBOARD APPELÉ');
        $user = \Auth::user();
        // Vérification stricte : le gestionnaire doit être propriétaire de la résidence
        $residence = \App\Models\Residence::where('id', $user->residence_id)
            ->where('owner_id', $user->id)
            ->first();
        // Correction automatique : crée et associe la résidence si besoin
        if (!$residence) {
            $residence = \App\Models\Residence::create([
                'name' => 'Résidence de ' . $user->name,
                'address' => '',
                'owner_id' => $user->id,
            ]);
            $user->residence_id = $residence->id;
            $user->save();
        }

        $residenceId = $user->residence_id;
        $buildings = \App\Models\Building::where('residence_id', $residenceId)->count();
        $apartments = \App\Models\Apartment::whereHas('building', function($q) use ($residenceId) {
            $q->where('residence_id', $residenceId);
        })->count();
        $tenants = \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->count();
        $paymentsQuery = \App\Models\Payment::whereHas('apartment', function($q) use ($residenceId) {
            $q->whereHas('building', function($qq) use ($residenceId) {
                $qq->where('residence_id', $residenceId);
            });
        });

        $payments = (clone $paymentsQuery)->sum('amount');
        $paidPayments = (clone $paymentsQuery)->where('status', 'paid')->sum('amount');
        $pendingPayments = (clone $paymentsQuery)->where('status', 'pending')->sum('amount');
        $paymentCount = (clone $paymentsQuery)->count();
        $paidCount = (clone $paymentsQuery)->where('status', 'paid')->count();
        $collectionRate = $paymentCount > 0 ? round(($paidCount / $paymentCount) * 100) : 0;

        // Variables supplémentaires pour la vue
        $occupiedCount = \App\Models\Apartment::where('status', 'occupé')->whereHas('building', function($q) use ($residenceId) {
            $q->where('residence_id', $residenceId);
        })->count();
        $vacantCount = \App\Models\Apartment::where('status', 'libre')->whereHas('building', function($q) use ($residenceId) {
            $q->where('residence_id', $residenceId);
        })->count();
        $worksCount = \App\Models\Apartment::where('status', 'travaux')->whereHas('building', function($q) use ($residenceId) {
            $q->where('residence_id', $residenceId);
        })->count();
        $occupancyRate = $apartments > 0 ? round(($occupiedCount / $apartments) * 100) : 0;

        // Paiements mensuels réels
        $monthlyPayments = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyPayments[$i] = (clone $paymentsQuery)->where('status', 'paid')->whereHas('apartment', function($q) use ($residenceId) {
                $q->whereHas('building', function($qq) use ($residenceId) {
                    $qq->where('residence_id', $residenceId);
                });
            })->where('status', 'paid')
              ->whereMonth('date', $month->month)
              ->whereYear('date', $month->year)
              ->sum('amount');
        }

        // Paiements récents
        $recentPayments = (clone $paymentsQuery)->with(['tenant', 'apartment.building'])
          ->orderByDesc('date')
          ->orderByDesc('id')
          ->take(4)
          ->get();

        // Tickets récents et statistiques
        $ticketsQuery = \App\Models\Ticket::whereHas('apartment', function($q) use ($residenceId) {
            $q->whereHas('building', function($qq) use ($residenceId) {
                $qq->where('residence_id', $residenceId);
            });
        });
        $ticketsCount = (clone $ticketsQuery)->count();
        $openTickets = (clone $ticketsQuery)->where('status', 'open')->count();
        $inProgressTickets = (clone $ticketsQuery)->where('status', 'in_progress')->count();
        $closedTickets = (clone $ticketsQuery)->where('status', 'closed')->count();

        $recentTickets = (clone $ticketsQuery)
            ->with(['apartment.building', 'technician'])
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        // Loyers à venir calculés à partir des baux actifs et des paiements du mois courant
        $activeTenantApartments = \App\Models\TenantApartment::whereNull('end_date')
            ->whereHas('apartment.building', function($q) use ($residenceId) {
                $q->where('residence_id', $residenceId);
            })
            ->with(['tenant', 'apartment'])
            ->get();

        $upcomingRents = $activeTenantApartments->map(function ($tenantApartment) {
            $lastPaid = \App\Models\Payment::where('tenant_id', $tenantApartment->tenant_id)
                ->where('apartment_id', $tenantApartment->apartment_id)
                ->where('status', 'paid')
                ->latest('date')
                ->first();

            $dueDate = $lastPaid
                ? Carbon::parse($lastPaid->date)->addMonthNoOverflow()->endOfMonth()
                : now()->endOfMonth();

            $amount = $tenantApartment->apartment->rent_amount ?? 0;

            return (object) [
                'tenant' => $tenantApartment->tenant,
                'apartment' => $tenantApartment->apartment,
                'amount' => $amount,
                'due_date' => $dueDate,
            ];
        })->sortBy('due_date')->values();

        $upcomingRentCount = $upcomingRents->count();
        $upcomingRentAmount = $upcomingRents->sum('amount');

        return view('manager.dashboard', compact(
            'buildings', 'apartments', 'tenants', 'payments',
            'paidPayments', 'pendingPayments', 'paymentCount', 'paidCount', 'collectionRate',
            'occupiedCount', 'vacantCount', 'worksCount', 'occupancyRate',
            'monthlyPayments', 'recentPayments', 'recentTickets', 'upcomingRents',
            'ticketsCount', 'openTickets', 'inProgressTickets', 'closedTickets',
            'upcomingRentCount', 'upcomingRentAmount'
        ));
    }
}
