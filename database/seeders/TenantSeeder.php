<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TenantApartment;

class TenantSeeder extends Seeder
{
    public function run()
    {
        $tenant = User::updateOrCreate(
            [
                'email' => 'locataire@test.com',
            ],
            [
                'name' => 'Locataire Test',
                'password' => bcrypt('password'),
                'role' => 'tenant',
                'residence_id' => 1,
            ]
        );
        TenantApartment::updateOrCreate(
            [
                'tenant_id' => $tenant->id,
                'apartment_id' => 1,
            ],
            [
                'start_date' => now(),
                'code' => 'ABC123',
            ]
        );
    }
}
