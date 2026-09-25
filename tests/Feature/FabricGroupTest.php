<?php

namespace Tests\Feature;

use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FabricGroupTest extends TestCase
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

    public function test_can_create_fabric_group_with_multiple_fabrics(): void
    {
        $fab1 = Fabric::create([
            'fabric_code' => 'FAB-001',
            'fabric_name' => 'Cotton Single Jersey',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $fab2 = Fabric::create([
            'fabric_code' => 'FAB-002',
            'fabric_name' => 'Cotton Rib',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $response = $this->actingAs($this->user)->post('/fabric-groups', [
            'group_code' => 'FG-001',
            'group_name' => 'Cotton Knitted Fabrics',
            'description' => 'All cotton knits',
            'fabrics' => [$fab1->id, $fab2->id],
            'status' => 'Active',
        ]);

        $response->assertRedirect('/fabric-groups');
        $this->assertDatabaseHas('fabric_groups', ['group_code' => 'FG-001']);

        $group = FabricGroup::where('group_code', 'FG-001')->first();
        $this->assertCount(2, $group->fabrics);
    }

    public function test_requires_at_least_one_fabric_when_creating_group(): void
    {
        $response = $this->actingAs($this->user)->post('/fabric-groups', [
            'group_code' => 'FG-EMPTY',
            'group_name' => 'Empty Group',
            'fabrics' => [],
            'status' => 'Active',
        ]);

        $response->assertSessionHasErrors('fabrics');
    }

    public function test_can_view_fabric_group_and_its_assigned_fabrics(): void
    {
        $fab = Fabric::create([
            'fabric_code' => 'FAB-001',
            'fabric_name' => 'Cotton Single Jersey',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $group = FabricGroup::create([
            'group_code' => 'FG-001',
            'group_name' => 'Cotton Knitted Fabrics',
            'status' => 'Active',
        ]);
        $group->fabrics()->attach($fab->id);

        $response = $this->actingAs($this->user)->get("/fabric-groups/{$group->id}");

        $response->assertStatus(200);
        $response->assertSee('Cotton Knitted Fabrics');
        $response->assertSee('Cotton Single Jersey');
    }

    public function test_can_remove_fabric_from_group(): void
    {
        $fab = Fabric::create([
            'fabric_code' => 'FAB-001',
            'fabric_name' => 'Cotton Single Jersey',
            'fabric_type' => 'Knitted',
            'status' => 'Active',
        ]);

        $group = FabricGroup::create([
            'group_code' => 'FG-001',
            'group_name' => 'Cotton Knitted Fabrics',
            'status' => 'Active',
        ]);
        $group->fabrics()->attach($fab->id);

        $response = $this->actingAs($this->user)->delete("/fabric-groups/{$group->id}/fabrics/{$fab->id}");

        $response->assertRedirect();
        $this->assertCount(0, $group->fresh()->fabrics);
    }
}
