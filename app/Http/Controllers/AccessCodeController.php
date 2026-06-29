<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessCodeController extends Controller
{
    public function showForm()
    {
        return view('code-access-form');
    }

    public function submitCode(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);

        $code = trim($request->access_code);

        // 1. Cherche un technicien avec ce code
        $technician = Technician::where('code', $code)->first();
        if ($technician && $technician->user) {
            Auth::login($technician->user);
            $request->session()->regenerate();
            return redirect()->route('technician.dashboard');
        }

        // 2. Cherche un appartement avec ce code d'accès
        $apartment = Apartment::where('access_code', $code)->first();
        if ($apartment) {
            // Trouve le locataire actif de cet appartement
            $tenant = $apartment->tenants()
                ->wherePivot('end_date', null)
                ->orderByDesc('tenant_apartments.start_date')
                ->first();

            if ($tenant) {
                Auth::login($tenant);
                $request->session()->regenerate();
                return redirect()->route('tenant.dashboard');
            }

            return back()->with('error', 'Aucun locataire actif associé à cet appartement.');
        }

        return back()->with('error', 'Code invalide. Vérifiez votre code et réessayez.');
    }
}
