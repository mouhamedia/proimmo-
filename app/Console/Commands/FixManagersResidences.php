<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Residence;

class FixManagersResidences extends Command
{
    protected $signature = 'fix:managers-residences';
    protected $description = 'Corrige automatiquement les résidences des gestionnaires (manager)';

    public function handle()
    {
        $count = 0;
        User::where('role', 'manager')->get()->each(function($user) use (&$count) {
            $res = Residence::where('id', $user->residence_id)->where('owner_id', $user->id)->first();
            if (!$res) {
                $residence = Residence::create([
                    'name' => 'Résidence de ' . $user->name,
                    'address' => '',
                    'owner_id' => $user->id,
                ]);
                $user->residence_id = $residence->id;
                $user->save();
                $count++;
            }
        });
        $this->info("Résidences corrigées pour {$count} gestionnaire(s).");
    }
}
