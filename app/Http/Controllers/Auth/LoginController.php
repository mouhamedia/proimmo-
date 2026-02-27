<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traite la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Redirection selon le rôle
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($role === 'tenant') {
                return redirect('/tenant/dashboard');
            } elseif ($role === 'manager') {
                return redirect('/manager/dashboard');
            } else {
                return redirect('/');
            }
        }

        return back()->withErrors([
            'email' => 'Identifiants invalides',
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
