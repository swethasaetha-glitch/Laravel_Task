<?php

namespace App\Http\Controllers;

use App\Models\ProductionPlan;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class ProductionPlanController extends Controller
{
    public function index()
    {
        $plans = ProductionPlan::with('salesOrder.buyerOrder')->latest()->get();
        $salesOrders = SalesOrder::all();
        return view('production_planning.index', compact('plans', 'salesOrders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_no' => ['required', 'string', 'max:100', 'unique:production_plans,plan_no'],
            'sales_order_id' => ['required', 'exists:sales_orders,id'],
            'planned_start_date' => ['required', 'date'],
            'planned_end_date' => ['required', 'date'],
            'target_daily_qty' => ['required', 'integer', 'min:1'],
            'line_allocation' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'string'],
        ]);

        ProductionPlan::create($validated);

        return redirect()->back()->with('success', 'Production Plan generated & approved successfully!');
    }
}
