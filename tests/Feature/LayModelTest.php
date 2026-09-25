<?php

namespace Tests\Feature;

use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LayModelTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected FabricGroup $cottonGroup;
    protected FabricGroup $syntheticGroup;
    protected Fabric $cottonFabric;
    protected Fabric $polyesterFabric;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
        ]);

        $this->cottonGroup = FabricGroup::create([
            'group_code' => 'FG-001',
            'group_name' => 'Cotton Knitted Fabrics',
            'status' => 'Active',
        ]);

        $this->syntheticGroup = FabricGroup::create([
            'group_code' => 'FG-002',
            'group_name' => 'Synthetic Fabrics',
            'status' => 'Active',
        ]);

        $this->cottonFabric = Fabric::create([
            'fabric_code' => 'FAB-001',
            'fabric_name' => 'Cotton Single Jersey',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $this->polyesterFabric = Fabric::create([
            'fabric_code' => 'FAB-004',
            'fabric_name' => 'Polyester',
            'fabric_type' => 'Woven',
            'status' => 'Active',
        ]);

        $this->cottonGroup->fabrics()->attach($this->cottonFabric->id);
        $this->syntheticGroup->fabrics()->attach($this->polyesterFabric->id);
    }

    public function test_can_create_lay_model_with_valid_fabric_group_relationship(): void
    {
        $response = $this->actingAs($this->user)->post('/lay-models', [
            'lay_model_code' => 'LM-001',
            'lay_model_name' => "Men's T-Shirt Lay",
            'fabric_group_id' => $this->cottonGroup->id,
            'fabric_id' => $this->cottonFabric->id,
            'lay_length' => 12.50,
            'lay_width' => 72,
            'number_of_plies' => 50,
            'garment_size' => 'L',
            'marker_length' => 11.80,
            'marker_width' => 68,
            'status' => 'Active',
        ]);

        $response->assertRedirect('/lay-models');
        $this->assertDatabaseHas('lay_models', [
            'lay_model_code' => 'LM-001',
            'fabric_group_id' => $this->cottonGroup->id,
            'fabric_id' => $this->cottonFabric->id,
        ]);
    }

    public function test_rejects_fabric_that_does_not_belong_to_selected_fabric_group(): void
    {
        // Try assigning polyester fabric to cotton group
        $response = $this->actingAs($this->user)->post('/lay-models', [
            'lay_model_code' => 'LM-INVALID',
            'lay_model_name' => 'Invalid Combination Lay',
            'fabric_group_id' => $this->cottonGroup->id,
            'fabric_id' => $this->polyesterFabric->id, // Polyester does NOT belong to Cotton Group!
            'lay_length' => 10,
            'lay_width' => 60,
            'number_of_plies' => 30,
            'status' => 'Active',
        ]);

        $response->assertSessionHasErrors(['fabric_id' => 'The selected fabric does not belong to the selected fabric group.']);
        $this->assertDatabaseMissing('lay_models', ['lay_model_code' => 'LM-INVALID']);
    }

    public function test_can_view_lay_model_details(): void
    {
        $layModel = LayModel::create([
            'lay_model_code' => 'LM-001',
            'lay_model_name' => "Men's T-Shirt Lay",
            'fabric_group_id' => $this->cottonGroup->id,
            'fabric_id' => $this->cottonFabric->id,
            'lay_length' => 12.50,
            'lay_width' => 72,
            'number_of_plies' => 50,
            'status' => 'Active',
        ]);

        $response = $this->actingAs($this->user)->get("/lay-models/{$layModel->id}");

        $response->assertStatus(200);
        $response->assertSee("Men's T-Shirt Lay");
        $response->assertSee('Cotton Single Jersey');
    }

    public function test_can_update_lay_model(): void
    {
        $layModel = LayModel::create([
            'lay_model_code' => 'LM-001',
            'lay_model_name' => 'Original Lay Name',
            'fabric_group_id' => $this->cottonGroup->id,
            'fabric_id' => $this->cottonFabric->id,
            'lay_length' => 12.50,
            'lay_width' => 72,
            'number_of_plies' => 50,
            'status' => 'Active',
        ]);

        $response = $this->actingAs($this->user)->put("/lay-models/{$layModel->id}", [
            'lay_model_code' => 'LM-001',
            'lay_model_name' => 'Updated Lay Name',
            'fabric_group_id' => $this->cottonGroup->id,
            'fabric_id' => $this->cottonFabric->id,
            'lay_length' => 15.00,
            'lay_width' => 72,
            'number_of_plies' => 60,
            'status' => 'Active',
        ]);

        $response->assertRedirect('/lay-models');
        $this->assertDatabaseHas('lay_models', [
            'id' => $layModel->id,
            'lay_model_name' => 'Updated Lay Name',
            'number_of_plies' => 60,
        ]);
    }
}
