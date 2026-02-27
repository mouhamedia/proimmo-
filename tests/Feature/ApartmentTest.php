<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\User;

class ApartmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_apartment()
    {
        $manager = User::factory()->create(['role' => 'manager', 'residence_id' => 1]);
        $building = Building::factory()->create(['residence_id' => 1]);
        $this->actingAs($manager);

        $response = $this->post('/apartments', [
            'number' => 'C303',
            'type' => 'T4',
            'rent_amount' => 1500,
            'status' => 'libre',
            'building_id' => $building->id,
        ]);

        $response->assertRedirect('/apartments');
        $this->assertDatabaseHas('apartments', ['number' => 'C303']);
    }

    public function test_manager_can_edit_apartment()
    {
        $manager = User::factory()->create(['role' => 'manager', 'residence_id' => 1]);
        $building = Building::factory()->create(['residence_id' => 1]);
        $apartment = Apartment::factory()->create(['building_id' => $building->id]);
        $this->actingAs($manager);

        $response = $this->put('/apartments/'.$apartment->id, [
            'number' => 'C303-mod',
            'type' => 'T4',
            'rent_amount' => 1600,
            'status' => 'occupé',
            'building_id' => $building->id,
        ]);

        $response->assertRedirect('/apartments');
        $this->assertDatabaseHas('apartments', ['number' => 'C303-mod']);
    }

    public function test_manager_can_delete_apartment()
    {
        $manager = User::factory()->create(['role' => 'manager', 'residence_id' => 1]);
        $building = Building::factory()->create(['residence_id' => 1]);
        $apartment = Apartment::factory()->create(['building_id' => $building->id]);
        $this->actingAs($manager);

        $response = $this->delete('/apartments/'.$apartment->id);

        $response->assertRedirect('/apartments');
        $this->assertDatabaseMissing('apartments', ['id' => $apartment->id]);
    }
}
