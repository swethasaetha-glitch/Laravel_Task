<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;
use App\Models\BuyerOrder;
use App\Models\SalesOrder;
use App\Models\ProductionPlan;
use App\Models\FabricPo;
use App\Models\FabricGrn;
use App\Models\FabricRoll;
use App\Models\FabricInspection;
use App\Models\FabricRelaxation;
use App\Models\LaySlip;
use App\Models\ProductionBundle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Initial Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('ChangeMe@123'),
                'role' => 'Admin',
            ]
        );

        // 2. Buyer Order & Sales Order (ERP Entry)
        $buyerOrder = BuyerOrder::updateOrCreate(
            ['po_number' => 'PO-NK-2026-001'],
            [
                'buyer_name' => 'Nike International',
                'order_date' => '2026-09-01',
                'delivery_date' => '2026-10-15',
                'total_garment_qty' => 5000,
                'status' => 'Confirmed',
            ]
        );

        $salesOrder = SalesOrder::updateOrCreate(
            ['sales_order_no' => 'SO-2026-101'],
            [
                'buyer_order_id' => $buyerOrder->id,
                'style_no' => 'ST-789',
                'garment_type' => "Men's Polo",
                'colorway' => 'Black / White',
                'size_ratio' => 'S:1, M:2, L:2, XL:1',
                'order_qty' => 2500,
                'status' => 'In Production',
            ]
        );

        // 3. Production Planning
        $prodPlan = ProductionPlan::updateOrCreate(
            ['plan_no' => 'PP-2026-001'],
            [
                'sales_order_id' => $salesOrder->id,
                'planned_start_date' => '2026-09-05',
                'planned_end_date' => '2026-09-28',
                'target_daily_qty' => 500,
                'line_allocation' => 'Sewing Line 1 & Line 2',
                'status' => 'Approved',
            ]
        );

        // 4. Fabrics Master
        $fab1 = Fabric::updateOrCreate(
            ['fabric_code' => 'FAB-001'],
            [
                'fabric_name' => 'Cotton Single Jersey',
                'fabric_type' => 'Knitted',
                'composition' => '100% Cotton',
                'color' => 'Black',
                'gsm' => 180,
                'width' => 72,
                'unit' => 'KG',
                'description' => 'Single jersey knitted fabric for t-shirts.',
                'status' => 'Active',
            ]
        );

        $fab2 = Fabric::updateOrCreate(
            ['fabric_code' => 'FAB-002'],
            [
                'fabric_name' => 'Cotton Rib',
                'fabric_type' => 'Knitted',
                'composition' => '100% Cotton',
                'color' => 'White',
                'gsm' => 220,
                'width' => 68,
                'unit' => 'KG',
                'description' => 'Rib knitted fabric for collars and cuffs.',
                'status' => 'Active',
            ]
        );

        $fab3 = Fabric::updateOrCreate(
            ['fabric_code' => 'FAB-003'],
            [
                'fabric_name' => 'Cotton Interlock',
                'fabric_type' => 'Knitted',
                'composition' => '100% Cotton',
                'color' => 'Navy',
                'gsm' => 200,
                'width' => 70,
                'unit' => 'KG',
                'description' => 'Double knit interlock fabric.',
                'status' => 'Active',
            ]
        );

        // 5. Fabric Procurement (PO) & Receiving (GRN)
        $fabricPo = FabricPo::updateOrCreate(
            ['po_no' => 'FPO-2026-001'],
            [
                'sales_order_id' => $salesOrder->id,
                'fabric_id' => $fab1->id,
                'supplier_name' => 'Acme Textile Mills',
                'required_qty' => 1250.50,
                'unit' => 'KG',
                'delivery_date' => '2026-09-10',
                'status' => 'Ordered',
            ]
        );

        $fabricGrn = FabricGrn::updateOrCreate(
            ['grn_no' => 'GRN-2026-001'],
            [
                'fabric_po_id' => $fabricPo->id,
                'supplier_invoice_no' => 'INV-98765',
                'received_date' => '2026-09-10',
                'total_rolls_received' => 3,
                'received_qty' => 1250.00,
                'status' => 'Received',
            ]
        );

        // 6. Fabric Rolls (Store Bins)
        $roll1 = FabricRoll::updateOrCreate(
            ['roll_no' => 'R-GRN-2026-001-01'],
            [
                'fabric_grn_id' => $fabricGrn->id,
                'fabric_id' => $fab1->id,
                'gross_weight' => 416.60,
                'net_weight' => 408.20,
                'width' => 72.00,
                'shade' => 'Shade A',
                'bin_location' => 'BIN-A12',
                'inspection_status' => 'Passed',
                'relaxation_status' => 'Relaxed',
            ]
        );

        $roll2 = FabricRoll::updateOrCreate(
            ['roll_no' => 'R-GRN-2026-001-02'],
            [
                'fabric_grn_id' => $fabricGrn->id,
                'fabric_id' => $fab1->id,
                'gross_weight' => 416.60,
                'net_weight' => 408.20,
                'width' => 72.00,
                'shade' => 'Shade A',
                'bin_location' => 'BIN-A13',
                'inspection_status' => 'Passed',
                'relaxation_status' => 'Relaxed',
            ]
        );

        // 7. Fabric 4-Point Inspection & Relaxation
        FabricInspection::updateOrCreate(
            ['inspection_no' => 'INSP-2026-001'],
            [
                'fabric_roll_id' => $roll1->id,
                'inspected_length' => 100.00,
                'total_penalty_points' => 8,
                'points_per_100_sq_yds' => 4.00,
                'grade' => 'Grade A',
                'inspector_name' => 'Admin Quality',
                'status' => 'Passed',
                'notes' => 'Uniform shade, zero slubs detected.',
            ]
        );

        FabricRelaxation::updateOrCreate(
            ['relaxation_no' => 'REL-2026-001'],
            [
                'fabric_roll_id' => $roll1->id,
                'start_time' => '2026-09-11 08:00:00',
                'end_time' => '2026-09-12 08:00:00',
                'required_hours' => 24,
                'shrinkage_pct' => 1.20,
                'status' => 'Ready for Lay',
            ]
        );

        // 8. Fabric Groups & Lay Models
        $group1 = FabricGroup::updateOrCreate(
            ['group_code' => 'FG-001'],
            [
                'group_name' => 'Cotton Knitted Fabrics',
                'description' => 'All cotton knitted fabrics for garment production.',
                'status' => 'Active',
            ]
        );
        $group1->fabrics()->sync([$fab1->id, $fab2->id, $fab3->id]);

        $layModel1 = LayModel::updateOrCreate(
            ['lay_model_code' => 'LM-001'],
            [
                'lay_model_name' => "Men's T-Shirt Lay",
                'fabric_group_id' => $group1->id,
                'fabric_id' => $fab1->id,
                'lay_length' => 12.50,
                'lay_width' => 72.00,
                'number_of_plies' => 50,
                'garment_size' => 'L',
                'marker_length' => 11.80,
                'marker_width' => 68.00,
                'description' => "Standard lay for men's basic t-shirt cutting.",
                'status' => 'Active',
            ]
        );

        // 9. Lay Slips (Lay Process Completed)
        LaySlip::updateOrCreate(
            ['lay_slip_no' => 'LS-2026-001'],
            [
                'production_plan_id' => $prodPlan->id,
                'lay_model_id' => $layModel1->id,
                'fabric_group_id' => $group1->id,
                'table_no' => 'Table 03',
                'spreader_operator' => 'Robert / Spreading Team A',
                'total_plies' => 50,
                'lay_length' => 12.50,
                'marker_efficiency_pct' => 88.50,
                'status' => 'Lay Completed',
                'notes' => 'Lay process completed successfully with zero tension distortion.',
            ]
        );

        // 10. Production Bundles
        ProductionBundle::updateOrCreate(
            ['bundle_no' => 'BND-001'],
            [
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
            ]
        );
    }
}
