<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('technician_id', Auth::id())
            ->latest()
            ->get();

        return view('technician.tickets', compact('tickets'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $ticket = Ticket::where('id', $id)
            ->where('technician_id', Auth::id())
            ->firstOrFail();

        $ticket->update(['status' => $request->status]);

        return redirect()->route('technician.tickets.index')
            ->with('success', 'Statut mis à jour.');
    }
}
