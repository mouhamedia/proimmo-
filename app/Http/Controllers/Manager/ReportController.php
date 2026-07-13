<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Payment;
use App\Models\Residence;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $residence = Residence::where('id', $user->residence_id)
            ->where('owner_id', $user->id)
            ->first();

        if (! $residence) {
            $residence = Residence::create([
                'name' => 'Résidence de ' . $user->name,
                'address' => '',
                'owner_id' => $user->id,
            ]);

            $user->residence_id = $residence->id;
            $user->save();
        }

        $residenceId = $residence->id;

        $buildings = Building::where('residence_id', $residenceId)->count();
        $apartments = Apartment::whereHas('building', function ($query) use ($residenceId) {
            $query->where('residence_id', $residenceId);
        });

        $apartmentCount = (clone $apartments)->count();
        $occupiedCount = (clone $apartments)->where('status', 'occupé')->count();
        $vacantCount = (clone $apartments)->where('status', 'libre')->count();
        $worksCount = (clone $apartments)->where('status', 'travaux')->count();

        $tenants = User::where('role', 'tenant')->where('residence_id', $residenceId)->count();
        $technicians = User::where('role', 'technician')->where('residence_id', $residenceId)->count();

        $paymentsBase = Payment::whereHas('apartment', function ($query) use ($residenceId) {
            $query->whereHas('building', function ($buildingQuery) use ($residenceId) {
                $buildingQuery->where('residence_id', $residenceId);
            });
        });

        $totalPayments = (clone $paymentsBase)->sum('amount');
        $paidPayments = (clone $paymentsBase)->where('status', 'paid')->sum('amount');
        $pendingPayments = (clone $paymentsBase)->where('status', 'pending')->sum('amount');
        $paidCount = (clone $paymentsBase)->where('status', 'paid')->count();
        $paymentCount = (clone $paymentsBase)->count();

        $ticketBase = Ticket::whereHas('apartment', function ($query) use ($residenceId) {
            $query->whereHas('building', function ($buildingQuery) use ($residenceId) {
                $buildingQuery->where('residence_id', $residenceId);
            });
        });

        $ticketCount = (clone $ticketBase)->count();
        $openTickets = (clone $ticketBase)->where('status', 'open')->count();
        $progressTickets = (clone $ticketBase)->where('status', 'in_progress')->count();
        $closedTickets = (clone $ticketBase)->where('status', 'closed')->count();

        $monthlyRevenue = [];
        $monthlyLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $monthlyLabels[] = $monthDate->format('M');
            $monthlyRevenue[] = (clone $paymentsBase)
                ->where('status', 'paid')
                ->whereMonth('date', $monthDate->month)
                ->whereYear('date', $monthDate->year)
                ->sum('amount');
        }

        $recentPayments = (clone $paymentsBase)
            ->with(['tenant', 'apartment'])
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        $recentTickets = (clone $ticketBase)
            ->with(['apartment', 'technician'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $occupancyRate = $apartmentCount > 0 ? round(($occupiedCount / $apartmentCount) * 100) : 0;
        $collectionRate = $paymentCount > 0 ? round(($paidCount / $paymentCount) * 100) : 0;
        $ticketResolutionRate = $ticketCount > 0 ? round(($closedTickets / $ticketCount) * 100) : 0;

        $lastMonthRevenue = $monthlyRevenue[4] ?? 0;
        $currentMonthRevenue = $monthlyRevenue[5] ?? 0;
        $revenueDelta = $lastMonthRevenue > 0
            ? round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
            : null;

        $insights = $this->buildInsights([
            'occupancyRate' => $occupancyRate,
            'collectionRate' => $collectionRate,
            'ticketResolutionRate' => $ticketResolutionRate,
            'openTickets' => $openTickets,
            'progressTickets' => $progressTickets,
            'vacantCount' => $vacantCount,
            'worksCount' => $worksCount,
            'pendingPayments' => $pendingPayments,
            'currentMonthRevenue' => $currentMonthRevenue,
            'revenueDelta' => $revenueDelta,
        ]);

        return view('manager.reports.index', compact(
            'residence',
            'buildings',
            'apartmentCount',
            'occupiedCount',
            'vacantCount',
            'worksCount',
            'tenants',
            'technicians',
            'totalPayments',
            'paidPayments',
            'pendingPayments',
            'paymentCount',
            'ticketCount',
            'openTickets',
            'progressTickets',
            'closedTickets',
            'monthlyLabels',
            'monthlyRevenue',
            'recentPayments',
            'recentTickets',
            'occupancyRate',
            'collectionRate',
            'ticketResolutionRate',
            'revenueDelta',
            'insights'
        ));
    }

    private function buildInsights(array $metrics): array
    {
        $insights = [];

        if ($metrics['occupancyRate'] >= 85) {
            $insights[] = 'Occupation excellente: la résidence est très bien remplie et le potentiel de vacance est faible.';
        } elseif ($metrics['occupancyRate'] >= 60) {
            $insights[] = 'Occupation correcte, mais plusieurs lots restent disponibles. Un suivi commercial ciblé peut améliorer le taux de remplissage.';
        } else {
            $insights[] = 'Occupation faible: le parc locatif n’est pas encore optimisé et nécessite une action rapide sur les lots vacants.';
        }

        if ($metrics['collectionRate'] >= 80) {
            $insights[] = 'Encaissement solide: la plupart des paiements enregistrés sont honorés.';
        } else {
            $insights[] = 'Encaissement à renforcer: une relance des impayés et des paiements en attente est recommandée.';
        }

        if ($metrics['ticketResolutionRate'] >= 70) {
            $insights[] = 'Le traitement des tickets est maîtrisé, avec une bonne part de demandes déjà clôturées.';
        } else {
            $insights[] = 'Les tickets s’accumulent: il faut prioriser les demandes ouvertes et accélérer les interventions.';
        }

        if ($metrics['revenueDelta'] !== null) {
            if ($metrics['revenueDelta'] > 0) {
                $insights[] = 'Le revenu du mois progresse de ' . $metrics['revenueDelta'] . '% par rapport au mois précédent.';
            } elseif ($metrics['revenueDelta'] < 0) {
                $insights[] = 'Le revenu du mois recule de ' . abs($metrics['revenueDelta']) . '% par rapport au mois précédent.';
            } else {
                $insights[] = 'Le revenu du mois est stable par rapport au mois précédent.';
            }
        }

        if ($metrics['vacantCount'] > 0) {
            $insights[] = $metrics['vacantCount'] . ' appartement(s) sont encore vacants et peuvent être reloués rapidement.';
        }

        if ($metrics['worksCount'] > 0) {
            $insights[] = $metrics['worksCount'] . ' appartement(s) sont en travaux et peuvent peser temporairement sur l’occupation.';
        }

        if ($metrics['pendingPayments'] > 0) {
            $insights[] = 'Des paiements en attente totalisent ' . number_format($metrics['pendingPayments'], 0, ',', ' ') . ' FCFA.';
        }

        return $insights;
    }
}