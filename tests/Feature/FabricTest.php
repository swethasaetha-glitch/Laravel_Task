<?php

namespace Tests\Feature;

use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FabricTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
        ]);
    }

    public function test_can_view_fabrics_index_and_search(): void
    {
        Fabric::create([
            'fabric_code' => 'FAB-001',
            'fabric_name' => 'Cotton Single Jersey',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $response = $this->actingAs($this->user)->get('/fabrics?search=Single');
        $response->assertStatus(200);
        $response->assertSee('FAB-001');
        $response->assertSee('Cotton Single Jersey');
    }

    public function test_can_create_fabric(): void
    {
        $data = [
            'fabric_code' => 'FAB-100',
            'fabric_name' => 'Cotton Pique',
            'fabric_type' => 'Knitted',
            'composition' => '100% Cotton',
            'color' => 'Red',
            'gsm' => 200,
            'width' => 70,
            'unit' => 'KG',
            'description' => 'Pique knit for polo shirts.',
            'status' => 'Active',
        ];

        $response = $this->actingAs($this->user)->post('/fabrics', $data);

        $response->assertRedirect('/fabrics');
        $this->assertDatabaseHas('fabrics', ['fabric_code' => 'FAB-100', 'fabric_name' => 'Cotton Pique']);
    }

    public function test_validate_duplicate_fabric_code(): void
    {
        Fabric::create([
            'fabric_code' => 'FAB-DUP',
            'fabric_name' => 'Original Fabric',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $response = $this->actingAs($this->user)->post('/fabrics', [
            'fabric_code' => 'FAB-DUP',
            'fabric_name' => 'Duplicate Fabric',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $response->assertSessionHasErrors('fabric_code');
    }

    public function test_prevent_invalid_data_on_fabric_creation(): void
    {
        $response = $this->actingAs($this->user)->post('/fabrics', [
            'fabric_code' => '',
            'fabric_name' => '',
            'fabric_type' => '',
            'gsm' => -50,
        ]);

        $response->assertSessionHasErrors(['fabric_code', 'fabric_name', 'fabric_type', 'gsm']);
    }

    public function test_can_view_fabric_details(): void
    {
        $fabric = Fabric::create([
            'fabric_code' => 'FAB-002',
            'fabric_name' => 'Cotton Rib',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $response = $this->actingAs($this->user)->get("/fabrics/{$fabric->id}");
        $response->assertStatus(200);
        $response->assertSee('Cotton Rib');
    }

    public function test_can_update_fabric(): void
    {
        $fabric = Fabric::create([
            'fabric_code' => 'FAB-003',
            'fabric_name' => 'Old Name',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $response = $this->actingAs($this->user)->put("/fabrics/{$fabric->id}", [
            'fabric_code' => 'FAB-003',
            'fabric_name' => 'Updated Name',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $response->assertRedirect('/fabrics');
        $this->assertDatabaseHas('fabrics', ['id' => $fabric->id, 'fabric_name' => 'Updated Name']);
    }

    public function test_prevents_deletion_when_fabric_is_used_in_lay_model(): void
    {
        $fabric = Fabric::create([
            'fabric_code' => 'FAB-USE',
            'fabric_name' => 'Used Fabric',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $group = FabricGroup::create([
            'group_code' => 'FG-USE',
            'group_name' => 'Test Group',
            'status' => 'Active',
        ]);
        $group->fabrics()->attach($fabric->id);

        LayModel::create([
            'lay_model_code' => 'LM-USE',
            'lay_model_name' => 'Test Lay Model',
            'fabric_group_id' => $group->id,
            'fabric_id' => $fabric->id,
            'lay_length' => 10,
            'lay_width' => 60,
            'number_of_plies' => 20,
            'status' => 'Active',
        ]);

        $response = $this->actingAs($this->user)->delete("/fabrics/{$fabric->id}");

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('fabrics', ['id' => $fabric->id, 'deleted_at' => null]);
    }
}
