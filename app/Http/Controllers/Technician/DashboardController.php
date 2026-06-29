<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalAssigned  = Ticket::where('technician_id', $userId)->count();
        $openCount      = Ticket::where('technician_id', $userId)->where('status', 'open')->count();
        $inProgressCount = Ticket::where('technician_id', $userId)->where('status', 'in_progress')->count();
        $closedCount    = Ticket::where('technician_id', $userId)->where('status', 'closed')->count();

        $recentTickets = Ticket::where('technician_id', $userId)
            ->whereIn('status', ['open', 'in_progress'])
            ->latest()
            ->take(5)
            ->get();

        return view('technician.dashboard', compact(
            'totalAssigned',
            'openCount',
            'inProgressCount',
            'closedCount',
            'recentTickets'
        ));
    }
}
