@extends('layouts.app')

@section('title', 'Sewing Line Tracking & QC Inspection')
@section('page_header_title', 'Sewing Production & Line QC')
@section('page_header_subtitle', 'Track Tech Solutions | In-Line Inspection, Mid-Line QC & End-Line Checking')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue shadow-lg" data-bs-toggle="modal" data-bs-target="#sewingInspectionModal">
    <i class="bi bi-qr-code-scan fs-5"></i> Record Sewing QC Inspection
</button>
@endsection

@section('content')
<!-- Metric Summary Cards for 3 Sewing Stages -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">1. In-Line Issued</div>
            <div class="metric-card-value text-primary">{{ $sewInCount }}</div>
            <div class="metric-card-subtext">Bundles issued to sewing lines</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">2. Mid-Line Inspected</div>
            <div class="metric-card-value text-warning">{{ $midLineCount }}</div>
            <div class="metric-card-subtext">Assembly line QC checks</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">3. End-Line Passed</div>
            <div class="metric-card-value text-success">{{ $endLineCount }}</div>
            <div class="metric-card-subtext">Cleared sew out bundles</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Total QC Scans Today</div>
            <div class="metric-card-value text-info">{{ $scans->count() }}</div>
            <div class="metric-card-subtext">In-line, Mid-line & End-line logs</div>
        </div>
    </div>
</div>

<!-- Interactive Modal: Record Sewing QC Inspection (In-Line, Mid-Line, End-Line) -->
<div class="modal fade" id="sewingInspectionModal" tabindex="-1" aria-labelledby="sewingInspectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-2xl border-0">
            <div class="modal-header bg-gradient-to-r from-sky-600 to-blue-700 text-white rounded-t-4 py-3">
                <h5 class="modal-title font-bold d-flex align-items-center gap-2" id="sewingInspectionModalLabel">
                    <i class="bi bi-patch-check-fill fs-4"></i> Record Sewing QC (In-Line, Mid-Line, End-Line)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('production.sewing.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 space-y-4">
                    <div class="alert alert-info py-2 px-3 mb-3 text-xs d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill fs-6"></i>
                        <span>Select the Bundle QR Ticket and recording stage: <strong>In-Line (Line Issue) &rarr; Mid-Line (Process QC) &rarr; End-Line (Sew Out Clearance)</strong></span>
                    </div>

                    <div class="row g-3">
                        <!-- Select Bundle QR Ticket -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Lot Bundle QR Ticket</label>
                            <select name="lot_bundle_id" required class="form-select form-select-custom">
                                <option value="" disabled selected>Select Bundle Ticket...</option>
                                @foreach($lotBundles as $bnd)
                                    <option value="{{ $bnd->id }}">{{ $bnd->bundle_no }} — Size: {{ $bnd->size }} ({{ $bnd->garment_qty }} Pcs) [Current Stage: {{ strtoupper(str_replace('_', ' ', $bnd->stage)) }}]</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Inspection Stage -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Sewing Inspection Stage</label>
                            <select name="scan_stage" required class="form-select form-select-custom">
                                <option value="in_line">1. In-Line Inspection (Line Start / Sew In)</option>
                                <option value="mid_line" selected>2. Mid-Line QC Tracking (Assembly Seams)</option>
                                <option value="end_line">3. End-Line Checking (Sew Out Clearance)</option>
                            </select>
                        </div>

                        <!-- Sewing Line Machine -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Sewing Machine & Line</label>
                            <select name="machine_id" class="form-select form-select-custom">
                                <option value="">Select Sewing Machine...</option>
                                @foreach($sewingMachines as $mc)
                                    <option value="{{ $mc->id }}">{{ $mc->machine_no }} — {{ $mc->machine_name }} ({{ $mc->line_no ?? 'Line 1' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sewing Operator -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Line Operator</label>
                            <select name="operator_id" class="form-select form-select-custom">
                                <option value="">Select Operator...</option>
                                @foreach($operators as $op)
                                    <option value="{{ $op->id }}">{{ $op->operator_code }} — {{ $op->name }} ({{ $op->skill_level }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Inspection Result -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Inspection Result</label>
                            <select name="inspection_result" required class="form-select form-select-custom">
                                <option value="pass">PASS — Approved</option>
                                <option value="rework">REWORK — Defect Detected</option>
                                <option value="reject">REJECT — Scrap</option>
                            </select>
                        </div>

                        <!-- Defect Code (if rework/reject) -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Garment Defect (If Rework)</label>
                            <select name="garment_defect_id" class="form-select form-select-custom">
                                <option value="">None / Pass</option>
                                @foreach($defects as $def)
                                    <option value="{{ $def->id }}">{{ $def->defect_code }} — {{ $def->defect_name }} ({{ $def->category }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small uppercase">Inspector Remarks / QC Notes</label>
                            <input type="text" name="remarks" placeholder="e.g. Seam tension adjusted on single needle machine." class="form-control form-control-custom">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-b-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue px-4">
                        <i class="bi bi-check-circle-fill me-1"></i> Save Inspection Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Stage 1 & 2 & 3 Interactive Tables -->

<!-- 1. Sewing Line QR Scan History & Logs -->
<div class="card-custom mb-4">
    <div class="card-custom-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="card-custom-title mb-0">Live Sewing Machine Scan Terminal Logs</h5>
                <p class="card-custom-subtitle mb-0">Timestamped records for In-Scan, Mid-Line QC, and Out-Scan</p>
            </div>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-bold">
                {{ $scans->count() }} Scans Logged
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th>Scan ID</th>
                        <th>Bundle Ticket</th>
                        <th>Scan Type</th>
                        <th>Machine</th>
                        <th>Operator</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scans as $sc)
                    <tr>
                        <td class="fw-bold text-primary">#SCAN-{{ $sc->id }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $sc->lotBundle?->bundle_no }}</div>
                            <div class="text-muted small" style="font-size:0.7rem;">Size: {{ $sc->lotBundle?->size }} ({{ $sc->lotBundle?->garment_qty }} Pcs)</div>
                        </td>
                        <td>
                            @if($sc->scan_type === 'in_scan')
                                <span class="badge bg-warning text-dark font-bold"><i class="bi bi-box-arrow-in-right me-1"></i> 1. IN-LINE (IN-SCAN)</span>
                            @elseif($sc->scan_type === 'mid_scan')
                                <span class="badge bg-info text-white font-bold"><i class="bi bi-gear-wide-connected me-1"></i> 2. MID-LINE QC</span>
                            @else
                                <span class="badge bg-success text-white font-bold"><i class="bi bi-box-arrow-right me-1"></i> 3. END-LINE (SEW OUT)</span>
                            @endif
                        </td>
                        <td class="fw-semibold text-dark">{{ $sc->machine?->machine_no ?? 'MC-SEW-101' }}</td>
                        <td>{{ $sc->operator?->name ?? 'Priya Ramesh' }}</td>
                        <td class="text-muted">{{ $sc->scanned_at?->format('H:i:s, d M Y') ?? now()->format('H:i:s, d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No sewing scans logged yet. Click "Record Sewing QC Inspection" above to scan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 2. Sewing Line Bundles Stage Status (Image 5: Sew In -> Mid Line -> Sew Out) -->
<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title mb-0">Sewing Bundle Flow (Image 5)</h5>
        <p class="card-custom-subtitle mb-3">Bundle tracking through In-Line &rarr; Mid-Line QC &rarr; End-Line &rarr; Laundry/Washing</p>

        <div class="table-responsive">
            <table class="table table-custom align-middle text-sm">
                <thead>
                    <tr>
                        <th>Bundle Ticket</th>
                        <th>Size & Shade</th>
                        <th>Garment Qty</th>
                        <th>Current Line Stage</th>
                        <th>Line Operator</th>
                        <th>Washing / Laundry Routing</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lotBundles as $bnd)
                    <tr>
                        <td class="fw-bold text-primary">{{ $bnd->bundle_no }}</td>
                        <td>
                            <span class="badge bg-secondary font-bold">{{ $bnd->size }}</span>
                            <span class="text-info fw-semibold ms-1">{{ $bnd->shade_group }}</span>
                        </td>
                        <td class="fw-bold text-success">{{ $bnd->garment_qty }} Pcs</td>
                        <td>
                            <span class="badge badge-active text-uppercase">
                                {{ str_replace('_', ' ', $bnd->stage) }}
                            </span>
                        </td>
                        <td>{{ $bnd->operator?->name ?? 'Priya Ramesh' }}</td>
                        <td>
                            @if(in_array($bnd->stage, ['sew_out', 'washing_laundry']))
                                <span class="badge bg-info text-uppercase"><i class="bi bi-water me-1"></i> Routed to Laundry</span>
                            @else
                                <span class="badge bg-light text-dark border"><i class="bi bi-clock me-1"></i> In Assembly</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
