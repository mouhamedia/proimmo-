<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;

class CheckExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expired';
    protected $description = 'Expire les abonnements terminés';

    public function handle()
    {
        $expired = Subscription::where('end_date', '<', now())->where('status', 'active')->get();
        foreach ($expired as $sub) {
            $sub->update(['status' => 'expired']);
        }
        $this->info('Abonnements expirés mis à jour.');
    }
}
