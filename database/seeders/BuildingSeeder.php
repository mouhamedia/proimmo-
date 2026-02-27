<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;

class BuildingSeeder extends Seeder
{
    public function run()
    {
        Building::create([
            'name' => 'Immeuble A',
            'floors' => 5,
            'residence_id' => 1,
            'address' => 'Adresse A',
        ]);
        Building::create([
            'name' => 'Immeuble B',
            'floors' => 3,
            'residence_id' => 1,
            'address' => 'Adresse B',
        ]);
    }
}
