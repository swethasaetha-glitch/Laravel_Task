<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\FabricGrn;
use App\Models\FabricPo;
use App\Models\FabricRoll;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class FabricProcurementController extends Controller
{
    public function pos()
    {
        $pos = FabricPo::with(['salesOrder', 'fabric'])->latest()->get();
        $salesOrders = SalesOrder::all();
        $fabrics = Fabric::where('status', 'Active')->get();
        return view('fabric_erp.pos', compact('pos', 'salesOrders', 'fabrics'));
    }

    public function storePo(Request $request)
    {
        $validated = $request->validate([
            'po_no' => ['required', 'string', 'max:100', 'unique:fabric_pos,po_no'],
            'sales_order_id' => ['required', 'exists:sales_orders,id'],
            'fabric_id' => ['required', 'exists:fabrics,id'],
            'supplier_name' => ['required', 'string', 'max:255'],
            'required_qty' => ['required', 'numeric', 'min:0.1'],
            'unit' => ['required', 'string', 'max:20'],
            'delivery_date' => ['required', 'date'],
            'status' => ['required', 'string'],
        ]);

        FabricPo::create($validated);

        return redirect()->back()->with('success', 'Fabric Purchase Order created successfully!');
    }

    public function grns()
    {
        $grns = FabricGrn::with(['fabricPo.fabric', 'rolls'])->latest()->get();
        $pos = FabricPo::where('status', 'Ordered')->get();
        return view('fabric_erp.grns', compact('grns', 'pos'));
    }

    public function storeGrn(Request $request)
    {
        $validated = $request->validate([
            'grn_no' => ['required', 'string', 'max:100', 'unique:fabric_grns,grn_no'],
            'fabric_po_id' => ['required', 'exists:fabric_pos,id'],
            'supplier_invoice_no' => ['required', 'string', 'max:100'],
            'received_date' => ['required', 'date'],
            'total_rolls_received' => ['required', 'integer', 'min:1'],
            'received_qty' => ['required', 'numeric', 'min:0.1'],
            'status' => ['required', 'string'],
        ]);

        $grn = FabricGrn::create($validated);

        // Auto generate roll entries for the GRN
        $po = FabricPo::find($validated['fabric_po_id']);
        for ($i = 1; $i <= $validated['total_rolls_received']; $i++) {
            $rollNo = 'R-' . $grn->grn_no . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            FabricRoll::create([
                'roll_no' => $rollNo,
                'fabric_grn_id' => $grn->id,
                'fabric_id' => $po->fabric_id,
                'gross_weight' => round($validated['received_qty'] / $validated['total_rolls_received'], 2),
                'net_weight' => round(($validated['received_qty'] / $validated['total_rolls_received']) * 0.98, 2),
                'width' => 72.00,
                'shade' => 'Shade A',
                'bin_location' => 'BIN-' . chr(64 + rand(1, 4)) . rand(10, 99),
                'inspection_status' => 'Pending',
                'relaxation_status' => 'Pending',
            ]);
        }

        return redirect()->back()->with('success', 'GRN & Rolls registered in Fabric Store successfully!');
    }
}
