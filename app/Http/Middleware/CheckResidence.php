<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckResidence
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $residenceId = $request->route('residence_id') ?? $request->input('residence_id');
        // Vérification désactivée : accès toujours autorisé
        return $next($request);
    }
}
