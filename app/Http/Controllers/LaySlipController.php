<?php

namespace App\Http\Controllers;

use App\Models\FabricGroup;
use App\Models\LayModel;
use App\Models\LaySlip;
use App\Models\ProductionPlan;
use Illuminate\Http\Request;

class LaySlipController extends Controller
{
    public function index()
    {
        $laySlips = LaySlip::with(['productionPlan.salesOrder', 'layModel', 'fabricGroup'])->latest()->get();
        $plans = ProductionPlan::with('salesOrder')->where('status', 'Approved')->get();
        $layModels = LayModel::where('status', 'Active')->get();
        $fabricGroups = FabricGroup::where('status', 'Active')->get();

        return view('lay_planning.index', compact('laySlips', 'plans', 'layModels', 'fabricGroups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lay_slip_no' => ['required', 'string', 'max:100', 'unique:lay_slips,lay_slip_no'],
            'production_plan_id' => ['required', 'exists:production_plans,id'],
            'lay_model_id' => ['required', 'exists:lay_models,id'],
            'fabric_group_id' => ['required', 'exists:fabric_groups,id'],
            'table_no' => ['required', 'string', 'max:50'],
            'spreader_operator' => ['required', 'string', 'max:100'],
            'total_plies' => ['required', 'integer', 'min:1'],
            'lay_length' => ['required', 'numeric', 'min:0.1'],
            'marker_efficiency_pct' => ['nullable', 'numeric', 'min:50', 'max:100'],
            'status' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        LaySlip::create($validated);

        return redirect()->back()->with('success', 'Lay Slip executed & Lay Process Completed successfully!');
    }
}
