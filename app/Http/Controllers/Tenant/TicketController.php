<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('tenant_id', Auth::id())
            ->latest()
            ->get();

        return view('tenant.tickets', compact('tickets'));
    }

    public function create()
    {
        $apartment = Auth::user()->apartment;

        if (!$apartment) {
            return redirect()->route('tenant.dashboard')
                ->with('error', 'Vous n\'avez pas d\'appartement assigné.');
        }

        return view('tenant.tickets_create', compact('apartment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|min:10|max:500',
        ]);

        $user = Auth::user();
        $apartment = $user->apartment;

        if (!$apartment) {
            return redirect()->route('tenant.dashboard')
                ->with('error', 'Aucun appartement assigné.');
        }

        Ticket::create([
            'tenant_id'    => $user->id,
            'apartment_id' => $apartment->id,
            'description'  => $request->description,
            'status'       => 'open',
        ]);

        return redirect()->route('tenant.tickets.index')
            ->with('success', 'Votre ticket a été soumis avec succès.');
    }
}
