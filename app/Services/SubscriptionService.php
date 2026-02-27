<?php
namespace App\Services;

use App\Models\Subscription;

class SubscriptionService
{
    public function activate($user, $plan)
    {
        return Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ]);
    }

    public function expire($subscription)
    {
        $subscription->update(['status' => 'expired']);
    }
}
