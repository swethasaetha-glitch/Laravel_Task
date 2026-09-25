<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Style;
use App\Models\Machine;
use App\Models\Operator;
use App\Models\Supervisor;
use App\Models\GarmentDefect;
use App\Models\Shade;
use App\Models\SalesOrder;
use App\Models\Fabric;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterAndCutPlanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_authenticated_user_can_view_masters_index()
    {
        $user = User::first();

        $response = $this->actingAs($user)->get(route('masters.index'));

        $response->assertStatus(200);
        $response->assertSee('Garment Master Management');
    }

    public function test_user_can_create_new_style_with_process_sequences()
    {
        $user = User::first();

        $response = $this->actingAs($user)->post(route('masters.styles.store'), [
            'style_no' => 'ST-TEST-100',
            'style_name' => 'Testing Shirt Style',
            'garment_type' => 'Shirts',
            'sam' => 18.50,
            'description' => 'Test shirt style',
        ]);

        $response->assertRedirect(route('masters.index', ['tab' => 'styles']));
        $this->assertDatabaseHas('styles', ['style_no' => 'ST-TEST-100']);
        $this->assertDatabaseHas('process_sequences', ['process_name' => 'Fabric Receiving & GRN']);
    }

    public function test_user_can_create_machine_operator_defect_shade()
    {
        $user = User::first();

        $this->actingAs($user)->post(route('masters.machines.store'), [
            'machine_no' => 'MC-TEST-99',
            'machine_name' => 'Test Machine',
            'machine_type' => 'Overlock',
            'department' => 'Sewing',
        ])->assertRedirect();

        $this->assertDatabaseHas('machines', ['machine_no' => 'MC-TEST-99']);
    }

    public function test_user_can_view_and_create_cut_plans()
    {
        $user = User::first();
        $so = SalesOrder::first();
        $fab = Fabric::first();

        $response = $this->actingAs($user)->get(route('cut-planning.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post(route('cut-planning.store'), [
            'sales_order_id' => $so->id,
            'fabric_id' => $fab->id,
            'cad_type' => 'Marker',
            'unit_of_measure' => 'Metres',
            'no_of_piles' => 120,
            'order_qty' => 1000,
            'extra_qty' => 20,
            'cut_plan_type' => 'step_down',
            'group_allocation' => 'fit_mode',
        ]);

        $response->assertRedirect(route('cut-planning.index'));
        $this->assertDatabaseHas('cut_plans', ['no_of_piles' => 120, 'cut_plan_type' => 'step_down']);
    }

    public function test_user_can_start_cut_order_from_modal()
    {
        $user = User::first();
        $so = SalesOrder::first();
        $fab = Fabric::first();

        $response = $this->actingAs($user)->get(route('production.cutting'));
        $response->assertStatus(200);
        $response->assertSee('Start New Cut Order');

        $response = $this->actingAs($user)->post(route('production.cutting.store'), [
            'sales_order_id' => $so->id,
            'fabric_id' => $fab->id,
            'table_no' => 'Table 01 (Auto Spreader)',
            'cutting_method' => 'Gerber Auto Cutter',
            'no_of_piles' => 150,
            'extra_qty' => 30,
        ]);

        $response->assertRedirect(route('production.cutting'));
        $this->assertDatabaseHas('cut_plans', ['no_of_piles' => 150]);
    }

    public function test_user_can_record_sewing_qc_scan()
    {
        $user = User::first();
        $bundle = \App\Models\LotBundle::first();

        $response = $this->actingAs($user)->get(route('production.sewing'));
        $response->assertStatus(200);
        $response->assertSee('Record Sewing QC Inspection');

        $response = $this->actingAs($user)->post(route('production.sewing.store'), [
            'lot_bundle_id' => $bundle->id,
            'scan_stage' => 'mid_line',
            'inspection_result' => 'pass',
            'remarks' => 'Seam inspection passed on line 1.',
        ]);

        $response->assertRedirect(route('production.sewing'));
        $this->assertDatabaseHas('sewing_machine_scans', ['scan_type' => 'mid_scan']);
        $this->assertDatabaseHas('lot_bundles', ['id' => $bundle->id, 'stage' => 'mid_line']);
    }
}
