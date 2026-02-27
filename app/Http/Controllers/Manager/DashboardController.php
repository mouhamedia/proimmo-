<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;

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
        $payments = \App\Models\Payment::whereHas('apartment', function($q) use ($residenceId) {
            $q->whereHas('building', function($qq) use ($residenceId) {
                $qq->where('residence_id', $residenceId);
            });
        })->sum('amount');

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

        // Paiements mensuels (exemple placeholder)
        $monthlyPayments = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthlyPayments[$i] = \App\Models\Payment::whereHas('apartment', function($q) use ($residenceId) {
                $q->whereHas('building', function($qq) use ($residenceId) {
                    $qq->where('residence_id', $residenceId);
                });
            })->whereMonth('created_at', now()->subMonths($i)->month)
              ->whereYear('created_at', now()->subMonths($i)->year)
              ->sum('amount');
        }

        // Paiements récents
        $recentPayments = \App\Models\Payment::whereHas('apartment', function($q) use ($residenceId) {
            $q->whereHas('building', function($qq) use ($residenceId) {
                $qq->where('residence_id', $residenceId);
            });
        })->orderBy('created_at', 'desc')->take(4)->get();

        // Loyers à venir (exemple placeholder)
        $upcomingRents = collect(); // Remplace par ta logique si tu as un modèle Rent

        return view('manager.dashboard', compact(
            'buildings', 'apartments', 'tenants', 'payments',
            'occupiedCount', 'vacantCount', 'worksCount',
            'monthlyPayments', 'recentPayments', 'upcomingRents'
        ));
    }
}
