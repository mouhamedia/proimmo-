<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Residence;

class ResidenceSeeder extends Seeder
{
    public function run()
    {
        Residence::create([
            'name' => 'Résidence Alpha',
            'address' => '123 rue Principale',
            'owner_id' => 1,
        ]);
        Residence::create([
            'name' => 'Résidence Beta',
            'address' => '456 avenue Secondaire',
            'owner_id' => 1,
        ]);
    }
}
