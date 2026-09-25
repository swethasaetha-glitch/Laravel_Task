<?php

namespace Tests\Feature;

use App\Models\ProductionBundle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductionBundleTest extends TestCase
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

    public function test_can_view_production_bundles_and_metrics(): void
    {
        ProductionBundle::create([
            'bundle_no' => 'BND-001',
            'buyer' => 'Nike',
            'style_no' => 'ST-789',
            'order_no' => 'ORD-101',
            'garment' => "Men's Polo",
            'color' => 'Black',
            'size' => 'L',
            'total_qty' => 1000,
            'completed_qty' => 180,
            'rejected_qty' => 0,
            'status' => 'Active',
        ]);

        $response = $this->actingAs($this->user)->get('/production/bundles');

        $response->assertStatus(200);
        $response->assertSee('BND-001');
        $response->assertSee('Nike');
        $response->assertSee('1,000');
    }

    public function test_can_create_new_production_bundle(): void
    {
        $response = $this->actingAs($this->user)->post('/production/bundles', [
            'bundle_no' => 'BND-100',
            'buyer' => 'Puma',
            'style_no' => 'ST-999',
            'order_no' => 'ORD-555',
            'garment' => 'Track Pants',
            'color' => 'Navy',
            'size' => 'XL',
            'total_qty' => 500,
            'completed_qty' => 0,
            'rejected_qty' => 0,
            'status' => 'Active',
        ]);

        $response->assertRedirect('/production/bundles');
        $this->assertDatabaseHas('production_bundles', [
            'bundle_no' => 'BND-100',
            'buyer' => 'Puma',
            'total_qty' => 500,
        ]);
    }

    public function test_can_delete_production_bundle(): void
    {
        $bundle = ProductionBundle::create([
            'bundle_no' => 'BND-DEL',
            'buyer' => 'Test',
            'style_no' => 'ST-000',
            'order_no' => 'ORD-000',
            'garment' => 'Cap',
            'total_qty' => 100,
            'status' => 'Active',
        ]);

        $response = $this->actingAs($this->user)->delete("/production/bundles/{$bundle->id}");

        $response->assertRedirect('/production/bundles');
        $this->assertDatabaseMissing('production_bundles', ['id' => $bundle->id]);
    }
}
