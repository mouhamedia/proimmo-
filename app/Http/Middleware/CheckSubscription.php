<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->role === 'manager' && (!$user->subscription || $user->subscription->status !== 'active')) {
            abort(403, 'Abonnement expiré ou inactif');
        }
        return $next($request);
    }
}
