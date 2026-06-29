<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user      = Auth::user();
        $apartment = $user->apartment;

        $ticketsCount = Ticket::where('tenant_id', $user->id)->count();
        $openTickets  = Ticket::where('tenant_id', $user->id)->where('status', 'open')->count();
        $paidCount    = Payment::where('tenant_id', $user->id)->where('status', 'paid')->count();
        $pendingCount = Payment::where('tenant_id', $user->id)->where('status', 'pending')->count();

        // Calcul des mois impayés
        $overdueCount  = 0;
        $overdueAmount = 0;
        $nextDueDate   = null;

        if ($apartment) {
            $pivot = $user->apartments()
                ->wherePivot('end_date', null)
                ->orderByDesc('tenant_apartments.start_date')
                ->first();

            $startDate = $pivot ? Carbon::parse($pivot->pivot->start_date)->startOfMonth() : now()->startOfMonth();
            $now       = now()->startOfMonth();
            $current   = $startDate->copy();

            $payments = Payment::where('tenant_id', $user->id)->get();

            while ($current->lte($now)) {
                $monthKey = $current->format('Y-m');
                $hasPaid  = $payments->contains(fn($p) =>
                    Carbon::parse($p->date)->format('Y-m') === $monthKey && $p->status === 'paid'
                );
                $hasPending = $payments->contains(fn($p) =>
                    Carbon::parse($p->date)->format('Y-m') === $monthKey && $p->status === 'pending'
                );

                if (!$hasPaid && !$hasPending && $current->lt($now)) {
                    $overdueCount++;
                }
                $current->addMonth();
            }

            $overdueAmount = $overdueCount * $apartment->rent_amount;
            $nextDueDate   = now()->endOfMonth();
        }

        $recentTickets  = Ticket::where('tenant_id', $user->id)->latest()->take(3)->get();
        $recentPayments = Payment::where('tenant_id', $user->id)->latest()->take(3)->get();

        return view('tenant.dashboard', compact(
            'apartment',
            'ticketsCount',
            'openTickets',
            'paidCount',
            'pendingCount',
            'overdueCount',
            'overdueAmount',
            'nextDueDate',
            'recentTickets',
            'recentPayments'
        ));
    }
}
