<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Gestionnaire Test',
            'email' => 'manager@test.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
            'residence_id' => 1,
        ]);
    }
}
