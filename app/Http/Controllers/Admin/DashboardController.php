<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // Affiche les statistiques globales
    public function index()
    {
        $managers = \App\Models\User::where('role', 'manager')->count();
        $activeSubscriptions = \App\Models\Subscription::where('status', 'active')->count();
        $expiredSubscriptions = \App\Models\Subscription::where('status', 'expired')->count();
        $revenues = \App\Models\Payment::sum('amount');
            return view('admin.dashboard');
    }
}
