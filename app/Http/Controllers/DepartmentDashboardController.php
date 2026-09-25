<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\LotBundle;
use App\Models\SewingMachineScan;
use App\Models\LaundryRecord;
use App\Models\QualityDashboardAudit;
use App\Models\GarmentDefect;
use Illuminate\Http\Request;

class DepartmentDashboardController extends Controller
{
    public function index()
    {
        $machines = Machine::withCount(['scans as in_scans_today' => function ($q) {
            $q->where('scan_type', 'in_scan')->whereDate('scanned_at', now());
        }, 'scans as out_scans_today' => function ($q) {
            $q->where('scan_type', 'out_scan')->whereDate('scanned_at', now());
        }])->get();

        $stageCounts = [
            'Fabric Store' => LotBundle::where('stage', 'cutting_completed')->count(),
            'Cutting' => LotBundle::where('stage', 'numbering_done')->count(),
            'Supermarket' => LotBundle::where('stage', 'supermarket')->count(),
            'Sewing In' => LotBundle::where('stage', 'sew_in')->count(),
            'Mid Line QC' => LotBundle::where('stage', 'mid_line')->count(),
            'Washing/Laundry' => LotBundle::where('stage', 'washing_laundry')->count(),
            'Finishing' => LotBundle::where('stage', 'finishing')->count(),
        ];

        $laundryBatches = LaundryRecord::with('lotBundle')->latest()->take(5)->get();
        $qualityAudits = QualityDashboardAudit::with('lotBundle', 'garmentDefect', 'operator', 'machine')->latest()->take(10)->get();

        $totalAudits = QualityDashboardAudit::count();
        $passedAudits = QualityDashboardAudit::where('audit_result', 'pass')->count();
        $dhuRate = $totalAudits > 0 ? round((($totalAudits - $passedAudits) / $totalAudits) * 100, 2) : 0;

        return view('dashboards.department', compact(
            'machines',
            'stageCounts',
            'laundryBatches',
            'qualityAudits',
            'dhuRate'
        ));
    }
}
