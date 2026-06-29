<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CodeLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);
        $tech = Technician::where('code', $request->code)->first();
        if (!$tech) {
            return redirect()->back()->with('error', 'Code invalide ou technicien non trouvé.');
        }
        $user = $tech->user;
        if ($user) {
            Auth::login($user);
            return redirect()->route('technician.dashboard');
        }
        return redirect()->back()->with('error', 'Utilisateur associé non trouvé.');
    }
}
