<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class StatsController extends Controller
{
    // Affiche les statistiques
    public function index()
    {
        $residences = \App\Models\Residence::count();
        $buildings = \App\Models\Building::count();
        $apartments = \App\Models\Apartment::count();
        $tenants = \App\Models\User::where('role', 'tenant')->count();
        $payments = \App\Models\Payment::sum('amount');
        return view('admin.stats', compact('residences', 'buildings', 'apartments', 'tenants', 'payments'));
    }
}
