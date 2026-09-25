<?php

namespace App\Http\Controllers;

use App\Models\FabricInspection;
use App\Models\FabricRelaxation;
use App\Models\FabricRoll;
use Illuminate\Http\Request;

class FabricInspectionController extends Controller
{
    public function inspectionIndex()
    {
        $inspections = FabricInspection::with('fabricRoll.fabric')->latest()->get();
        $pendingRolls = FabricRoll::where('inspection_status', 'Pending')->get();
        return view('fabric_erp.inspections', compact('inspections', 'pendingRolls'));
    }

    public function storeInspection(Request $request)
    {
        $validated = $request->validate([
            'inspection_no' => ['required', 'string', 'max:100', 'unique:fabric_inspections,inspection_no'],
            'fabric_roll_id' => ['required', 'exists:fabric_rolls,id'],
            'inspected_length' => ['required', 'numeric', 'min:1'],
            'total_penalty_points' => ['required', 'integer', 'min:0'],
            'inspector_name' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        // Calculate 4-Point System score: (Points * 3600) / (Inspected Yds * Width In Inches)
        $roll = FabricRoll::findOrFail($validated['fabric_roll_id']);
        $pointsPer100Yds = round(($validated['total_penalty_points'] * 3600) / ($validated['inspected_length'] * ($roll->width ?: 72)), 2);

        $grade = $pointsPer100Yds <= 20 ? 'Grade A' : ($pointsPer100Yds <= 40 ? 'Grade B' : 'Grade C');
        $status = $pointsPer100Yds <= 40 ? 'Passed' : 'Rejected';

        FabricInspection::create([
            'inspection_no' => $validated['inspection_no'],
            'fabric_roll_id' => $validated['fabric_roll_id'],
            'inspected_length' => $validated['inspected_length'],
            'total_penalty_points' => $validated['total_penalty_points'],
            'points_per_100_sq_yds' => $pointsPer100Yds,
            'grade' => $grade,
            'inspector_name' => $validated['inspector_name'],
            'status' => $status,
            'notes' => $validated['notes'],
        ]);

        $roll->update(['inspection_status' => $status]);

        return redirect()->back()->with('success', "4-Point Inspection completed. Roll scored {$pointsPer100Yds} pts/100 sq yds ({$grade} - {$status})!");
    }

    public function relaxationIndex()
    {
        $relaxations = FabricRelaxation::with('fabricRoll.fabric')->latest()->get();
        $passedRolls = FabricRoll::where('inspection_status', 'Passed')->get();
        return view('fabric_erp.relaxations', compact('relaxations', 'passedRolls'));
    }

    public function storeRelaxation(Request $request)
    {
        $validated = $request->validate([
            'relaxation_no' => ['required', 'string', 'max:100', 'unique:fabric_relaxations,relaxation_no'],
            'fabric_roll_id' => ['required', 'exists:fabric_rolls,id'],
            'start_time' => ['required', 'date'],
            'required_hours' => ['required', 'integer', 'min:1'],
            'shrinkage_pct' => ['nullable', 'numeric', 'min:0'],
        ]);

        $startTime = \Carbon\Carbon::parse($validated['start_time']);
        $endTime = (clone $startTime)->addHours((int)$validated['required_hours']);

        FabricRelaxation::create([
            'relaxation_no' => $validated['relaxation_no'],
            'fabric_roll_id' => $validated['fabric_roll_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'required_hours' => $validated['required_hours'],
            'shrinkage_pct' => $validated['shrinkage_pct'] ?? 1.5,
            'status' => 'Relaxed',
        ]);

        $roll = FabricRoll::find($validated['fabric_roll_id']);
        $roll->update(['relaxation_status' => 'Relaxed']);

        return redirect()->back()->with('success', 'Fabric Relaxation log completed! Roll is ready for lay planning.');
    }
}
