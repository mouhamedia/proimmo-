<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Residence;
use App\Models\User;

class ResidenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_residence()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $this->actingAs($manager);

        $response = $this->post('/residences', [
            'name' => 'Résidence Test',
            'address' => '1 rue test',
        ]);

        $response->assertRedirect('/residences');
        $this->assertDatabaseHas('residences', ['name' => 'Résidence Test']);
    }

    public function test_manager_can_edit_residence()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $residence = Residence::factory()->create(['owner_id' => $manager->id]);
        $this->actingAs($manager);

        $response = $this->put('/residences/'.$residence->id, [
            'name' => 'Résidence Modifiée',
            'address' => '2 rue modifiée',
        ]);

        $response->assertRedirect('/residences');
        $this->assertDatabaseHas('residences', ['name' => 'Résidence Modifiée']);
    }

    public function test_manager_can_delete_residence()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $residence = Residence::factory()->create(['owner_id' => $manager->id]);
        $this->actingAs($manager);

        $response = $this->delete('/residences/'.$residence->id);

        $response->assertRedirect('/residences');
        $this->assertDatabaseMissing('residences', ['id' => $residence->id]);
    }
}
