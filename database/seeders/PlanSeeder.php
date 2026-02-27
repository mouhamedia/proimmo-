<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::create(['name' => 'Basic', 'price' => 10000, 'max_apartments' => 10]);
        Plan::create(['name' => 'Pro', 'price' => 25000, 'max_apartments' => 50]);
        Plan::create(['name' => 'Premium', 'price' => 50000, 'max_apartments' => 200]);
    }
}
