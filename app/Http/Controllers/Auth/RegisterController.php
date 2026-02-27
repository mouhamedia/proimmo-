<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Affiche le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Traite l'inscription
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'manager',
        ]);

        // Forcer la création de la résidence et l'association immédiate
        if ($user->role === 'manager' && empty($user->residence_id)) {
            $residence = \App\Models\Residence::create([
                'name' => 'Résidence de ' . $user->name,
                'address' => '',
                'owner_id' => $user->id,
            ]);
            $user->residence_id = $residence->id;
            $user->save();
        }

        // Recharge l'utilisateur pour avoir le residence_id à jour
        $user->refresh();
        Auth::login($user);
        // Redirection selon le rôle
        $role = $user->role;
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
}
