<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Apartment;
use App\Models\TenantApartment;

class TenantTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_tenant()
    {
        $manager = User::factory()->create(['role' => 'manager', 'residence_id' => 1]);
        $apartment = Apartment::factory()->create(['building_id' => 1]);
        $this->actingAs($manager);

        $response = $this->post('/tenants', [
            'name' => 'Locataire Test',
            'email' => 'locataire@test.com',
            'password' => 'password',
            'apartment_id' => $apartment->id,
        ]);

        $response->assertRedirect('/tenants');
        $this->assertDatabaseHas('users', ['email' => 'locataire@test.com']);
        $this->assertDatabaseHas('tenant_apartments', ['tenant_id' => User::where('email', 'locataire@test.com')->first()->id]);
    }

    public function test_manager_can_edit_tenant()
    {
        $manager = User::factory()->create(['role' => 'manager', 'residence_id' => 1]);
        $apartment = Apartment::factory()->create(['building_id' => 1]);
        $tenant = User::factory()->create(['role' => 'tenant', 'residence_id' => 1]);
        $this->actingAs($manager);

        $response = $this->put('/tenants/'.$tenant->id, [
            'name' => 'Locataire Modifié',
            'email' => 'locataire_mod@test.com',
            'apartment_id' => $apartment->id,
        ]);

        $response->assertRedirect('/tenants');
        $this->assertDatabaseHas('users', ['email' => 'locataire_mod@test.com']);
    }

    public function test_manager_can_delete_tenant()
    {
        $manager = User::factory()->create(['role' => 'manager', 'residence_id' => 1]);
        $tenant = User::factory()->create(['role' => 'tenant', 'residence_id' => 1]);
        $this->actingAs($manager);

        $response = $this->delete('/tenants/'.$tenant->id);

        $response->assertRedirect('/tenants');
        $this->assertDatabaseMissing('users', ['id' => $tenant->id]);
    }
}
