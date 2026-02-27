<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Apartment;

class ApartmentSeeder extends Seeder
{
    public function run()
    {
        Apartment::updateOrCreate(
            [ 'access_code' => 'A101CODE' ],
            [
                'number' => 'A101',
                'type' => 'T2',
                'rent_amount' => 800,
                'status' => 'libre',
                'building_id' => 1,
            ]
        );
        Apartment::updateOrCreate(
            [ 'access_code' => 'B202CODE' ],
            [
                'number' => 'B202',
                'type' => 'T3',
                'rent_amount' => 1200,
                'status' => 'occupé',
                'building_id' => 2,
            ]
        );
    }
}
