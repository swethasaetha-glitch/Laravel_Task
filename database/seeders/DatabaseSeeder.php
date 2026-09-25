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
use App\Models\TrackTechApp;
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

        // 11. Track Tech Solution 24 App Modules (Matching Screenshot)
        $appsData = [
            ['sno' => 1, 'app_name' => 'Critical Operation', 'package_name' => 'criticaloperation', 'live_version' => '1.0.0', 'test_version' => '1.0.0'],
            ['sno' => 2, 'app_name' => 'Layman', 'package_name' => 'layman', 'live_version' => '2.0.1', 'test_version' => '2.0.2', 'route_name' => 'lay-slips.index'],
            ['sno' => 3, 'app_name' => 'Sewing', 'package_name' => 'sewing', 'live_version' => '2.1.4', 'test_version' => '2.1.4', 'route_name' => 'production.sewing'],
            ['sno' => 4, 'app_name' => 'Cutman', 'package_name' => 'cutman', 'live_version' => '2.0.1', 'test_version' => '2.0.2', 'route_name' => 'production.cutting'],
            ['sno' => 5, 'app_name' => 'Cutting Inspection', 'package_name' => 'cuttinginspection', 'live_version' => '2.0.1', 'test_version' => '2.0.2'],
            ['sno' => 6, 'app_name' => 'Fabric Reserve', 'package_name' => 'fabricreserve', 'live_version' => '2.0.1', 'test_version' => '2.0.1'],
            ['sno' => 7, 'app_name' => 'Fabric Store', 'package_name' => 'fabricstore', 'live_version' => '1.0.0', 'test_version' => '1.0.0', 'route_name' => 'fabrics.index'],
            ['sno' => 8, 'app_name' => 'Mobile Dashboard', 'package_name' => 'mobiledashboard', 'live_version' => '2.0.1', 'test_version' => '2.0.1', 'route_name' => 'dashboard'],
            ['sno' => 9, 'app_name' => 'Operation', 'package_name' => 'operation', 'live_version' => '2.0.1', 'test_version' => '2.0.1'],
            ['sno' => 10, 'app_name' => 'Panel Inspection', 'package_name' => 'panelinspection', 'live_version' => '2.0.1', 'test_version' => '2.0.1'],
            ['sno' => 11, 'app_name' => 'Panel Recutting', 'package_name' => 'panelrecutting', 'live_version' => '2.0.1', 'test_version' => '2.0.1'],
            ['sno' => 12, 'app_name' => 'TV Dashboard', 'package_name' => 'tvdashboard', 'live_version' => '2.0.1', 'test_version' => '1.0.1'],
            ['sno' => 13, 'app_name' => 'QR Status', 'package_name' => 'qrstatus', 'live_version' => '2.0.1', 'test_version' => '2.0.1'],
            ['sno' => 14, 'app_name' => 'Super Market', 'package_name' => 'supermarket', 'live_version' => '2.0.2', 'test_version' => '2.0.4'],
            ['sno' => 15, 'app_name' => 'Roving Qc', 'package_name' => 'rovingqc', 'live_version' => '2.0.1', 'test_version' => '2.0.1', 'route_name' => 'production.quality'],
            ['sno' => 16, 'app_name' => 'Number Bundling', 'package_name' => 'numberingbundling', 'live_version' => '2.0.1', 'test_version' => '2.0.1', 'route_name' => 'production.bundles'],
            ['sno' => 17, 'app_name' => 'Packing', 'package_name' => 'packing', 'live_version' => '2.0.1', 'test_version' => '2.0.1', 'route_name' => 'production.packing'],
            ['sno' => 18, 'app_name' => 'Unit Transfer', 'package_name' => 'unittransfer', 'live_version' => '2.0.1', 'test_version' => '2.0.1'],
            ['sno' => 19, 'app_name' => 'Spotwash', 'package_name' => 'spotwash', 'live_version' => '2.0.1', 'test_version' => '2.0.1'],
            ['sno' => 20, 'app_name' => 'Operator Production', 'package_name' => 'operatorprodcution', 'live_version' => '2.0.1', 'test_version' => '2.0.1'],
            ['sno' => 21, 'app_name' => 'Special Process', 'package_name' => 'specialprocess', 'live_version' => '2.0.1', 'test_version' => '2.0.1'],
            ['sno' => 22, 'app_name' => 'Consolidate Dashbored', 'package_name' => 'consolidateddashbored', 'live_version' => '2.0.1', 'test_version' => '2.0.1'],
            ['sno' => 23, 'app_name' => 'Manual Reject Recutting', 'package_name' => 'manualrejectrecutting', 'live_version' => '1.0.0', 'test_version' => '1.0.0'],
            ['sno' => 24, 'app_name' => 'Fabric Inspection', 'package_name' => 'fabricinspection', 'live_version' => '1.0.0', 'test_version' => '1.0.0', 'route_name' => 'fabric-inspections.index'],
        ];

        foreach ($appsData as $app) {
            TrackTechApp::updateOrCreate(
                ['sno' => $app['sno']],
                [
                    'app_name' => $app['app_name'],
                    'package_name' => $app['package_name'],
                    'live_version' => $app['live_version'],
                    'test_version' => $app['test_version'],
                    'category' => 'Track Tech Module',
                    'route_name' => $app['route_name'] ?? null,
                    'status' => 'ONLINE',
                ]
            );
        }

        // 12. Garment Masters Data
        $style1 = \App\Models\Style::updateOrCreate(
            ['style_no' => 'ST-789'],
            [
                'style_name' => 'Men Cotton Polo',
                'buyer_order_id' => $buyerOrder->id,
                'garment_type' => 'Shirts',
                'sam' => 22.50,
                'description' => 'Premium combed cotton polo with rib collar.',
                'status' => 'active',
            ]
        );

        $sequences = [
            ['sequence_order' => 1, 'process_name' => 'Fabric Receiving & GRN', 'department' => 'Fabric', 'sam' => 2.0],
            ['sequence_order' => 2, 'process_name' => 'Fabric Relaxation', 'department' => 'Fabric', 'sam' => 1.5],
            ['sequence_order' => 3, 'process_name' => 'CAD Marker & Lay Plan', 'department' => 'CAD', 'sam' => 3.0],
            ['sequence_order' => 4, 'process_name' => 'Fabric Laying & Cutting', 'department' => 'Cutting', 'sam' => 4.0],
            ['sequence_order' => 5, 'process_name' => 'Numbering & Bundle QR', 'department' => 'Cutting', 'sam' => 2.0],
            ['sequence_order' => 6, 'process_name' => 'Sew In Terminal Scan', 'department' => 'Sewing', 'sam' => 1.0],
            ['sequence_order' => 7, 'process_name' => 'Assembly & Mid Line QC', 'department' => 'Sewing', 'sam' => 6.0],
            ['sequence_order' => 8, 'process_name' => 'Sew Out Scan', 'department' => 'Sewing', 'sam' => 1.0],
            ['sequence_order' => 9, 'process_name' => 'Washing / Laundry Process', 'department' => 'Washing', 'sam' => 1.5],
            ['sequence_order' => 10, 'process_name' => 'Finishing & Final Quality', 'department' => 'Finishing', 'sam' => 0.5],
        ];

        foreach ($sequences as $seq) {
            \App\Models\ProcessSequence::updateOrCreate(
                ['style_id' => $style1->id, 'sequence_order' => $seq['sequence_order']],
                $seq
            );
        }

        $m1 = \App\Models\Machine::updateOrCreate(
            ['machine_no' => 'MC-CUT-01'],
            ['machine_name' => 'Gerber Auto Cutter 01', 'machine_type' => 'Auto Cutter', 'department' => 'Cutting', 'line_no' => 'Cut Line 1', 'status' => 'active']
        );
        $m2 = \App\Models\Machine::updateOrCreate(
            ['machine_no' => 'MC-SEW-101'],
            ['machine_name' => 'Juki Single Needle 101', 'machine_type' => 'Single Needle', 'department' => 'Sewing', 'line_no' => 'Line 1', 'status' => 'active']
        );
        $m3 = \App\Models\Machine::updateOrCreate(
            ['machine_no' => 'MC-WASH-01'],
            ['machine_name' => 'Industrial Washing Drum 01', 'machine_type' => 'Washing Drum', 'department' => 'Washing', 'line_no' => 'Laundry Line', 'status' => 'active']
        );

        $op1 = \App\Models\Operator::updateOrCreate(
            ['operator_code' => 'OP-1001'],
            ['name' => 'Karthik Kumar', 'department' => 'Cutting', 'skill_level' => 'Grade A', 'line_no' => 'Cut Line 1', 'status' => 'active']
        );
        $op2 = \App\Models\Operator::updateOrCreate(
            ['operator_code' => 'OP-1002'],
            ['name' => 'Priya Ramesh', 'department' => 'Sewing', 'skill_level' => 'Grade A', 'line_no' => 'Line 1', 'status' => 'active']
        );

        $sup1 = \App\Models\Supervisor::updateOrCreate(
            ['supervisor_code' => 'SUP-501'],
            ['name' => 'Murugan V', 'department' => 'Sewing', 'shift' => 'Day']
        );

        $defects = [
            ['defect_code' => 'DEF-01', 'defect_name' => 'Skipped Stitch', 'category' => 'Sewing', 'severity' => 'major'],
            ['defect_code' => 'DEF-02', 'defect_name' => 'Shade Variation', 'category' => 'Fabric', 'severity' => 'critical'],
            ['defect_code' => 'DEF-03', 'defect_name' => 'Oil Stain', 'category' => 'Washing', 'severity' => 'minor'],
            ['defect_code' => 'DEF-04', 'defect_name' => 'Notch Missed', 'category' => 'Cutting', 'severity' => 'major'],
        ];
        foreach ($defects as $def) {
            \App\Models\GarmentDefect::updateOrCreate(['defect_code' => $def['defect_code']], $def);
        }

        \App\Models\Shade::updateOrCreate(
            ['shade_code' => 'SH-A1'],
            ['shade_group' => 'Shade A', 'allowance_min' => 0.60, 'allowance_max' => 0.70, 'description' => 'Standard Shade A tolerance']
        );

        // 13. Tapper Report & Roll Reservations
        \App\Models\TapperReport::updateOrCreate(
            ['tapper_no' => 'TPR-2026-001'],
            [
                'fabric_id' => $fab1->id,
                'roll_no' => 'R-GRN-2026-001-01',
                'before_shrinkage_len' => 100.00,
                'before_shrinkage_width' => 72.00,
                'after_shrinkage_len' => 98.80,
                'after_shrinkage_width' => 71.10,
                'shrinkage_percent' => 1.20,
                'shade_group' => 'Shade A',
                'arvind_approval_status' => 'Approved',
                'allowance_value' => 0.70,
                'quality_notes' => 'Passed tapper test with 0.70 allowance limit.',
            ]
        );

        \App\Models\FabricRollReservation::updateOrCreate(
            ['reservation_no' => 'RES-2026-001'],
            [
                'fabric_roll_id' => $roll1->id,
                'requested_by_dept' => 'Cutting Room',
                'status' => 'reserved',
                'storage_location' => 'BIN-A12',
            ]
        );

        // 14. Cut Plan & Lot Bundles
        $cutPlan = \App\Models\CutPlan::updateOrCreate(
            ['cut_plan_no' => 'CP-2026-001'],
            [
                'sales_order_id' => $salesOrder->id,
                'fabric_id' => $fab1->id,
                'cad_type' => 'Marker',
                'unit_of_measure' => 'Metres',
                'no_of_piles' => 100,
                'size_breakup' => ['S' => 250, 'M' => 500, 'L' => 500, 'XL' => 250],
                'order_qty' => 1500,
                'extra_qty' => 50,
                'cut_plan_type' => 'selected_ratio',
                'group_allocation' => 'automatic',
                'status' => 'in_cutting',
            ]
        );

        $bundle = \App\Models\LotBundle::updateOrCreate(
            ['bundle_no' => 'LOT-BND-1001'],
            [
                'qr_code_hash' => 'QR-HASH-ST789-L-001',
                'cut_plan_id' => $cutPlan->id,
                'lay_slip_id' => null,
                'style_id' => $style1->id,
                'size' => 'L',
                'shade_group' => 'Shade A',
                'garment_qty' => 20,
                'operator_id' => $op1->id,
                'supervisor_id' => $sup1->id,
                'machine_id' => $m1->id,
                'stage' => 'sew_in',
            ]
        );

        \App\Models\SewingMachineScan::updateOrCreate(
            ['lot_bundle_id' => $bundle->id, 'scan_type' => 'in_scan'],
            [
                'machine_id' => $m2->id,
                'operator_id' => $op2->id,
                'department' => 'Sewing',
                'scanned_at' => now(),
            ]
        );

        \App\Models\LaundryRecord::updateOrCreate(
            ['wash_batch_no' => 'WASH-2026-001'],
            [
                'lot_bundle_id' => $bundle->id,
                'wash_type' => 'Enzyme Softener Wash',
                'status' => 'in_washing',
                'received_at' => now(),
            ]
        );

        \App\Models\QualityDashboardAudit::updateOrCreate(
            ['lot_bundle_id' => $bundle->id],
            [
                'garment_defect_id' => null,
                'operator_id' => $op2->id,
                'machine_id' => $m2->id,
                'department' => 'Sewing',
                'defect_count' => 0,
                'audit_result' => 'pass',
                'remarks' => 'First inspection passed cleanly.',
            ]
        );

    }
}
