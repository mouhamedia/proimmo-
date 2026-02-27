<?php
namespace App\Services;

use App\Models\Payment;

class PaymentService
{
    public function processPayment($tenant, $apartment, $amount, $method)
    {
        // Logique de paiement (Wave, Stripe...)
        return Payment::create([
            'tenant_id' => $tenant->id,
            'apartment_id' => $apartment->id,
            'amount' => $amount,
            'status' => 'paid',
            'payment_method' => $method,
            'date' => now(),
        ]);
    }
}
