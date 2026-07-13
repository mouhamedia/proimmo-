<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Residence;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $residence = Residence::where('id', $user->residence_id)
            ->where('owner_id', $user->id)
            ->first();

        if (! $residence) {
            $residence = Residence::create([
                'name' => 'Résidence de ' . $user->name,
                'address' => '',
                'owner_id' => $user->id,
            ]);

            $user->residence_id = $residence->id;
            $user->save();
        }

        $paymentsQuery = Payment::whereHas('apartment', function ($query) use ($residence) {
            $query->whereHas('building', function ($buildingQuery) use ($residence) {
                $buildingQuery->where('residence_id', $residence->id);
            });
        })->with(['tenant', 'apartment.building'])->orderByDesc('date')->orderByDesc('id');

        $payments = $paymentsQuery->paginate(12);
        $totalAmount = (clone $paymentsQuery)->sum('amount');
        $paidAmount = (clone $paymentsQuery)->where('status', 'paid')->sum('amount');
        $pendingAmount = (clone $paymentsQuery)->where('status', 'pending')->sum('amount');
        $paidCount = (clone $paymentsQuery)->where('status', 'paid')->count();
        $paymentCount = (clone $paymentsQuery)->count();

        return view('manager.payments.index', compact(
            'residence',
            'payments',
            'totalAmount',
            'paidAmount',
            'pendingAmount',
            'paidCount',
            'paymentCount'
        ));
    }
}