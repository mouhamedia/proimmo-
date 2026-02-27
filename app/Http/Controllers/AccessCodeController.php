<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccessCodeController extends Controller
{
    // Affiche le formulaire de saisie de code
    public function showForm()
    {
        return view('code-access-form');
    }

    // Traite la soumission du code
    public function submitCode(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);

        // Recherche du code en base (à implémenter)
        // $code = AccessCode::where('code', $request->access_code)->active()->first();
        // if (!$code) {
        //     return back()->with('error', 'Code invalide ou expiré.');
        // }
        // if ($code->type === 'tenant') {
        //     Session::put('tenant_id', $code->target_id);
        //     return redirect()->route('tenant.dashboard');
        // }
        // if ($code->type === 'technician') {
        //     Session::put('technician_id', $code->target_id);
        //     return redirect()->route('technician.dashboard');
        // }
        // return back()->with('error', 'Type de code inconnu.');

        // Placeholder temporaire
        return back()->with('error', 'La validation du code n\'est pas encore implémentée.');
    }
}
