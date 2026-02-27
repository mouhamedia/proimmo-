<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenantApartment;
use App\Models\Technician;

class DashboardController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $residenceId = $user->residence_id ?? null;
        $buildings = $residenceId ? \App\Models\Building::where('residence_id', $residenceId)->count() : 0;
        $apartments = $residenceId ? \App\Models\Apartment::whereHas('building', function($q) use ($residenceId) {
            $q->where('residence_id', $residenceId);
        })->count() : 0;
        $tenants = $residenceId ? \App\Models\User::where('role', 'tenant')->where('residence_id', $residenceId)->count() : 0;
        $payments = $residenceId ? \App\Models\Payment::whereHas('apartment', function($q) use ($residenceId) {
            $q->whereHas('building', function($qq) use ($residenceId) {
                $qq->where('residence_id', $residenceId);
            });
        })->sum('amount') : 0;
        return view('dashboard', compact('buildings', 'apartments', 'tenants', 'payments'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = auth()->user();

        if($user->role == 'tenant') {
            $tenantApartment = TenantApartment::where('tenant_id', $user->id)
                                    ->where('code', $request->code)
                                    ->first();
            if(!$tenantApartment) {
                return back()->withErrors(['code' => 'Code invalide']);
            }
            // Redirige vers la liste des paiements du locataire
            return redirect()->route('payments.index');
        }

        if($user->role == 'technician') {
            $technician = Technician::where('user_id', $user->id)
                                    ->where('code', $request->code)
                                    ->first();
            if(!$technician) {
                return back()->withErrors(['code' => 'Code invalide']);
            }
            // Redirige vers la liste des tickets/incidents
            return redirect()->route('tickets.index');
        }

        // manager/admin : pas besoin de code
        return redirect()->route('manager.dashboard');
    }
}
