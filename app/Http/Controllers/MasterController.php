<?php

namespace App\Http\Controllers;

use App\Models\Style;
use App\Models\ProcessSequence;
use App\Models\Machine;
use App\Models\Operator;
use App\Models\Supervisor;
use App\Models\GarmentDefect;
use App\Models\Shade;
use App\Models\BuyerOrder;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'styles');

        $styles = Style::with('buyerOrder', 'processSequences')->latest()->paginate(10);
        $buyerOrders = BuyerOrder::all();
        $machines = Machine::latest()->paginate(10);
        $operators = Operator::latest()->paginate(10);
        $supervisors = Supervisor::latest()->paginate(10);
        $defects = GarmentDefect::latest()->paginate(10);
        $shades = Shade::latest()->paginate(10);

        return view('masters.index', compact(
            'tab',
            'styles',
            'buyerOrders',
            'machines',
            'operators',
            'supervisors',
            'defects',
            'shades'
        ));
    }

    public function storeStyle(Request $request)
    {
        $validated = $request->validate([
            'style_no' => 'required|string|unique:styles,style_no',
            'style_name' => 'required|string',
            'buyer_order_id' => 'nullable|exists:buyer_orders,id',
            'garment_type' => 'required|string',
            'sam' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $style = Style::create($validated);

        // Auto-create default process sequences
        $defaultSequences = [
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

        foreach ($defaultSequences as $seq) {
            ProcessSequence::create(array_merge($seq, ['style_id' => $style->id]));
        }

        return redirect()->route('masters.index', ['tab' => 'styles'])
            ->with('success', 'Style and process sequence created successfully.');
    }

    public function storeMachine(Request $request)
    {
        $validated = $request->validate([
            'machine_no' => 'required|string|unique:machines,machine_no',
            'machine_name' => 'required|string',
            'machine_type' => 'required|string',
            'department' => 'required|string',
            'line_no' => 'nullable|string',
        ]);

        Machine::create($validated);

        return redirect()->route('masters.index', ['tab' => 'machines'])
            ->with('success', 'Machine created successfully.');
    }

    public function storeOperator(Request $request)
    {
        $validated = $request->validate([
            'operator_code' => 'required|string|unique:operators,operator_code',
            'name' => 'required|string',
            'department' => 'required|string',
            'skill_level' => 'required|string',
            'line_no' => 'nullable|string',
        ]);

        Operator::create($validated);

        return redirect()->route('masters.index', ['tab' => 'operators'])
            ->with('success', 'Operator created successfully.');
    }

    public function storeSupervisor(Request $request)
    {
        $validated = $request->validate([
            'supervisor_code' => 'required|string|unique:supervisors,supervisor_code',
            'name' => 'required|string',
            'department' => 'required|string',
            'shift' => 'required|string',
        ]);

        Supervisor::create($validated);

        return redirect()->route('masters.index', ['tab' => 'supervisors'])
            ->with('success', 'Supervisor created successfully.');
    }

    public function storeDefect(Request $request)
    {
        $validated = $request->validate([
            'defect_code' => 'required|string|unique:garment_defects,defect_code',
            'defect_name' => 'required|string',
            'category' => 'required|string',
            'severity' => 'required|string',
        ]);

        GarmentDefect::create($validated);

        return redirect()->route('masters.index', ['tab' => 'defects'])
            ->with('success', 'Defect Code created successfully.');
    }

    public function storeShade(Request $request)
    {
        $validated = $request->validate([
            'shade_code' => 'required|string|unique:shades,shade_code',
            'shade_group' => 'required|string',
            'allowance_min' => 'required|numeric',
            'allowance_max' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Shade::create($validated);

        return redirect()->route('masters.index', ['tab' => 'shades'])
            ->with('success', 'Shade group created successfully.');
    }
}
