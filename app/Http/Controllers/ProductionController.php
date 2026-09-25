<?php

namespace App\Http\Controllers;

use App\Models\ProductionBundle;
use App\Models\CutPlan;
use App\Models\LaySlip;
use App\Models\LotBundle;
use App\Models\Machine;
use App\Models\Operator;
use App\Models\Supervisor;
use App\Models\SalesOrder;
use App\Models\Fabric;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function bundles(Request $request)
    {
        $query = ProductionBundle::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('bundle_no', 'like', "%{$search}%")
                  ->orWhere('buyer', 'like', "%{$search}%")
                  ->orWhere('style_no', 'like', "%{$search}%")
                  ->orWhere('order_no', 'like', "%{$search}%")
                  ->orWhere('garment', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($garment = $request->input('garment')) {
            $query->where('garment', 'like', "%{$garment}%");
        }

        if ($quantity = $request->input('quantity')) {
            if ($quantity === 'high') {
                $query->orderBy('total_qty', 'desc');
            } elseif ($quantity === 'low') {
                $query->orderBy('total_qty', 'asc');
            }
        } else {
            $query->latest();
        }

        $bundles = $query->get();

        $totalBundles = $bundles->count();
        $totalQuantity = $bundles->sum('total_qty');
        $completedQuantity = $bundles->sum('completed_qty');
        $rejectedQuantity = $bundles->sum('rejected_qty');

        return view('production.bundles', compact(
            'bundles',
            'totalBundles',
            'totalQuantity',
            'completedQuantity',
            'rejectedQuantity'
        ));
    }

    public function storeBundle(Request $request)
    {
        $validated = $request->validate([
            'bundle_no' => ['required', 'string', 'max:50', 'unique:production_bundles,bundle_no'],
            'buyer' => ['required', 'string', 'max:100'],
            'style_no' => ['required', 'string', 'max:100'],
            'order_no' => ['required', 'string', 'max:100'],
            'garment' => ['required', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:50'],
            'size' => ['nullable', 'string', 'max:50'],
            'total_qty' => ['required', 'integer', 'min:1'],
            'completed_qty' => ['nullable', 'integer', 'min:0'],
            'rejected_qty' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:Active,Completed,Pending'],
        ]);

        ProductionBundle::create($validated);

        return redirect()->route('production.bundles')->with('success', 'Production bundle created successfully!');
    }

    public function destroyBundle(ProductionBundle $bundle)
    {
        $bundle->delete();
        return redirect()->route('production.bundles')->with('success', 'Production bundle deleted successfully!');
    }

    public function cutting()
    {
        $cutPlans = CutPlan::with('salesOrder', 'fabric', 'lotBundles')->latest()->get();
        $laySlips = LaySlip::with('productionPlan', 'layModel', 'fabricGroup')->latest()->get();
        $lotBundles = LotBundle::with('cutPlan', 'style', 'operator', 'supervisor', 'machine')->latest()->get();
        $cuttingMachines = Machine::where('department', 'Cutting')->orWhere('machine_type', 'like', '%Cut%')->get();
        $operators = Operator::all();
        $supervisors = Supervisor::all();
        $salesOrders = SalesOrder::all();
        $fabrics = Fabric::all();

        return view('production.cutting', compact(
            'cutPlans',
            'laySlips',
            'lotBundles',
            'cuttingMachines',
            'operators',
            'supervisors',
            'salesOrders',
            'fabrics'
        ));
    }

    public function storeCutOrder(Request $request)
    {
        $validated = $request->validate([
            'sales_order_id' => 'required|exists:sales_orders,id',
            'fabric_id' => 'required|exists:fabrics,id',
            'machine_id' => 'nullable|exists:machines,id',
            'operator_id' => 'nullable|exists:operators,id',
            'supervisor_id' => 'nullable|exists:supervisors,id',
            'table_no' => 'required|string',
            'cutting_method' => 'required|string', // Straight Knife, Band Knife, Gerber Auto Cutter, Manual
            'no_of_piles' => 'required|integer|min:1',
            'extra_qty' => 'required|integer|min:0',
        ]);

        $so = SalesOrder::find($validated['sales_order_id']);
        $cutPlanNo = 'CP-' . date('Y') . '-' . str_pad(CutPlan::count() + 1, 3, '0', STR_PAD_LEFT);

        $cutPlan = CutPlan::create([
            'cut_plan_no' => $cutPlanNo,
            'sales_order_id' => $so->id,
            'fabric_id' => $validated['fabric_id'],
            'cad_type' => 'Marker',
            'unit_of_measure' => 'Metres',
            'no_of_piles' => $validated['no_of_piles'],
            'size_breakup' => ['S' => 250, 'M' => 500, 'L' => 500, 'XL' => 250],
            'order_qty' => $so->order_qty,
            'extra_qty' => $validated['extra_qty'],
            'cut_plan_type' => 'selected_ratio',
            'group_allocation' => 'automatic',
            'status' => 'in_cutting',
        ]);

        // Generate Lot Bundles with QR codes for Cutting Floor
        foreach (['S', 'M', 'L', 'XL'] as $size) {
            $bundleNo = 'BND-' . $cutPlan->cut_plan_no . '-' . $size;
            LotBundle::create([
                'bundle_no' => $bundleNo,
                'qr_code_hash' => 'QR-HASH-' . md5($bundleNo . time()),
                'cut_plan_id' => $cutPlan->id,
                'size' => $size,
                'shade_group' => 'Shade A',
                'garment_qty' => 25,
                'operator_id' => $validated['operator_id'] ?? null,
                'supervisor_id' => $validated['supervisor_id'] ?? null,
                'machine_id' => $validated['machine_id'] ?? null,
                'stage' => 'cutting_completed',
            ]);
        }

        return redirect()->route('production.cutting')
            ->with('success', 'Cutting order started successfully on ' . $validated['table_no'] . ' with QR bundle tickets generated.');
    }

    public function sewing()
    {
        return view('production.sewing');
    }

    public function quality()
    {
        return view('production.quality');
    }

    public function packing()
    {
        return view('production.packing');
    }
}
