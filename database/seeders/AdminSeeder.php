<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@immo-saas.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
    }
}
