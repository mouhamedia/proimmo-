<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Building;
use App\Models\User;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_building()
    {
        $manager = User::factory()->create(['role' => 'manager', 'residence_id' => 1]);
        $this->actingAs($manager);

        $response = $this->post('/buildings', [
            'name' => 'Immeuble Test',
            'floors' => 4,
        ]);

        $response->assertRedirect('/buildings');
        $this->assertDatabaseHas('buildings', ['name' => 'Immeuble Test']);
    }

    public function test_manager_can_edit_building()
    {
        $manager = User::factory()->create(['role' => 'manager', 'residence_id' => 1]);
        $building = Building::factory()->create(['residence_id' => 1]);
        $this->actingAs($manager);

        $response = $this->put('/buildings/'.$building->id, [
            'name' => 'Immeuble Modifié',
            'floors' => 2,
        ]);

        $response->assertRedirect('/buildings');
        $this->assertDatabaseHas('buildings', ['name' => 'Immeuble Modifié']);
    }

    public function test_manager_can_delete_building()
    {
        $manager = User::factory()->create(['role' => 'manager', 'residence_id' => 1]);
        $building = Building::factory()->create(['residence_id' => 1]);
        $this->actingAs($manager);

        $response = $this->delete('/buildings/'.$building->id);

        $response->assertRedirect('/buildings');
        $this->assertDatabaseMissing('buildings', ['id' => $building->id]);
    }
}
