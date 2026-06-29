<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user      = Auth::user();
        $apartment = $user->apartment;

        $payments     = Payment::where('tenant_id', $user->id)->latest()->get();
        $totalPaid    = Payment::where('tenant_id', $user->id)->where('status', 'paid')->sum('amount');
        $totalPending = Payment::where('tenant_id', $user->id)->where('status', 'pending')->sum('amount');

        // Calcul des mois depuis l'emménagement
        $months = collect();
        if ($apartment) {
            $pivot = $user->apartments()
                ->wherePivot('end_date', null)
                ->orderByDesc('tenant_apartments.start_date')
                ->first();

            $startDate = $pivot ? Carbon::parse($pivot->pivot->start_date)->startOfMonth() : now()->startOfMonth();
            $now       = now()->startOfMonth();

            $current = $startDate->copy();
            while ($current->lte($now)) {
                $monthKey = $current->format('Y-m');

                // Cherche un paiement payé pour ce mois
                $paid = $payments->first(function ($p) use ($monthKey) {
                    return Carbon::parse($p->date)->format('Y-m') === $monthKey
                        && $p->status === 'paid';
                });

                // Cherche un paiement en attente pour ce mois
                $pending = $payments->first(function ($p) use ($monthKey) {
                    return Carbon::parse($p->date)->format('Y-m') === $monthKey
                        && $p->status === 'pending';
                });

                $isCurrentMonth = $current->isSameMonth(now());
                $isOverdue      = $current->lt(now()->startOfMonth()) && !$paid && !$pending;

                $months->push([
                    'month'       => $current->copy(),
                    'label'       => ucfirst($current->translatedFormat('F Y')),
                    'paid'        => $paid,
                    'pending'     => $pending,
                    'overdue'     => $isOverdue,
                    'current'     => $isCurrentMonth,
                    'amount'      => $apartment->rent_amount,
                ]);

                $current->addMonth();
            }
        }

        $overdueCount  = $months->where('overdue', true)->count();
        $overdueAmount = $overdueCount * ($apartment?->rent_amount ?? 0);

        return view('tenant.payments', compact(
            'payments',
            'totalPaid',
            'totalPending',
            'months',
            'overdueCount',
            'overdueAmount',
            'apartment'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'month'          => 'required|string',
        ]);

        $user      = Auth::user();
        $apartment = $user->apartment;

        if (!$apartment) {
            return redirect()->route('tenant.payments.index')
                ->with('error', 'Aucun appartement assigné.');
        }

        // Vérifie qu'il n'y a pas déjà un paiement pour ce mois
        $monthDate = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
        $existing  = Payment::where('tenant_id', $user->id)
            ->whereYear('date', $monthDate->year)
            ->whereMonth('date', $monthDate->month)
            ->first();

        if ($existing) {
            return redirect()->route('tenant.payments.index')
                ->with('error', 'Un paiement existe déjà pour ce mois.');
        }

        Payment::create([
            'tenant_id'      => $user->id,
            'apartment_id'   => $apartment->id,
            'amount'         => $apartment->rent_amount,
            'status'         => 'pending',
            'payment_method' => $request->payment_method,
            'date'           => $monthDate->toDateString(),
        ]);

        return redirect()->route('tenant.payments.index')
            ->with('success', 'Paiement soumis pour ' . ucfirst($monthDate->translatedFormat('F Y')) . '. En attente de confirmation.');
    }
}
