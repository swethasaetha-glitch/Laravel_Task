<?php

namespace App\Http\Controllers;

use App\Models\CutPlan;
use App\Models\SalesOrder;
use App\Models\Fabric;
use App\Models\LotBundle;
use App\Models\Operator;
use App\Models\Supervisor;
use App\Models\Machine;
use Illuminate\Http\Request;

class CutRoomPlannerController extends Controller
{
    public function index()
    {
        $cutPlans = CutPlan::with('salesOrder', 'fabric', 'lotBundles')->latest()->paginate(10);
        $salesOrders = SalesOrder::all();
        $fabrics = Fabric::all();

        return view('cut_planning.index', compact('cutPlans', 'salesOrders', 'fabrics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sales_order_id' => 'required|exists:sales_orders,id',
            'fabric_id' => 'required|exists:fabrics,id',
            'cad_type' => 'required|in:Marker,Pattern',
            'unit_of_measure' => 'required|in:Metres,Kg',
            'no_of_piles' => 'required|integer|min:1',
            'order_qty' => 'required|integer|min:1',
            'extra_qty' => 'required|integer|min:0',
            'cut_plan_type' => 'required|string',
            'group_allocation' => 'required|string',
        ]);

        $cutPlanNo = 'CP-' . date('Y') . '-' . str_pad(CutPlan::count() + 1, 3, '0', STR_PAD_LEFT);

        $sizeBreakup = [
            'S' => (int) round($request->order_qty * 0.2),
            'M' => (int) round($request->order_qty * 0.3),
            'L' => (int) round($request->order_qty * 0.3),
            'XL' => (int) round($request->order_qty * 0.2),
        ];

        $cutPlan = CutPlan::create(array_merge($validated, [
            'cut_plan_no' => $cutPlanNo,
            'size_breakup' => $sizeBreakup,
            'status' => 'planned',
        ]));

        // Generate initial Lot Bundles for sizes
        $op = Operator::first();
        $sup = Supervisor::first();
        $mc = Machine::where('department', 'Cutting')->first();

        foreach (['S', 'M', 'L', 'XL'] as $size) {
            $bundleNo = 'BND-' . $cutPlan->cut_plan_no . '-' . $size;
            LotBundle::create([
                'bundle_no' => $bundleNo,
                'qr_code_hash' => 'QR-' . md5($bundleNo . time()),
                'cut_plan_id' => $cutPlan->id,
                'size' => $size,
                'shade_group' => 'Shade A',
                'garment_qty' => 25,
                'operator_id' => $op?->id,
                'supervisor_id' => $sup?->id,
                'machine_id' => $mc?->id,
                'stage' => 'cutting_completed',
            ]);
        }

        return redirect()->route('cut-planning.index')
            ->with('success', 'Cut Plan created successfully with auto-generated bundle QR records.');
    }
}
