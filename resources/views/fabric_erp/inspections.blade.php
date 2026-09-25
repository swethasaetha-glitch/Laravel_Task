@extends('layouts.app')

@section('title', 'Fabric Inspection')
@section('page_header_title', 'Fabric Quality Inspection (4-Point System)')
@section('page_header_subtitle', 'Stage 6: Fabric Defect Inspection & Roll Grading')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue" data-bs-toggle="modal" data-bs-target="#addInspectionModal">
    <i class="bi bi-patch-check"></i> Inspect Fabric Roll
</button>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-custom-body pb-0 px-0">
        <div class="d-flex justify-content-between align-items-center px-4 pb-3">
            <h5 class="fw-bold mb-0 text-dark">4-Point Inspection Logs</h5>
            <span class="text-muted small">{{ $inspections->count() }} log(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>INSPECTION NO</th>
                        <th>ROLL NO</th>
                        <th>FABRIC</th>
                        <th>INSPECTED YARDS</th>
                        <th>PENALTY POINTS</th>
                        <th>PTS / 100 SQ YDS</th>
                        <th>GRADE</th>
                        <th>INSPECTOR</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inspections as $ins)
                        <tr>
                            <td class="fw-bold text-primary">{{ $ins->inspection_no }}</td>
                            <td class="fw-bold">{{ $ins->fabricRoll ? $ins->fabricRoll->roll_no : '-' }}</td>
                            <td>{{ $ins->fabricRoll && $ins->fabricRoll->fabric ? $ins->fabricRoll->fabric->fabric_name : '-' }}</td>
                            <td>{{ $ins->inspected_length }} Yds</td>
                            <td><span class="badge bg-warning text-dark">{{ $ins->total_penalty_points }} pts</span></td>
                            <td class="fw-bold">{{ $ins->points_per_100_sq_yds }}</td>
                            <td><span class="badge bg-primary">{{ $ins->grade }}</span></td>
                            <td>{{ $ins->inspector_name }}</td>
                            <td>
                                @if($ins->status === 'Passed')
                                    <span class="badge-active">Passed</span>
                                @else
                                    <span class="badge-inactive">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No fabric roll inspections logged yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addInspectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-patch-check me-2"></i> Log 4-Point Fabric Inspection</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fabric-inspections.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Inspection No <span class="text-danger">*</span></label>
                            <input type="text" name="inspection_no" class="form-control form-control-custom" required placeholder="e.g. INSP-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Select Fabric Roll <span class="text-danger">*</span></label>
                            <select name="fabric_roll_id" class="form-select form-select-custom" required>
                                <option value="">-- Select Pending Roll --</option>
                                @foreach($pendingRolls as $roll)
                                    <option value="{{ $roll->id }}">{{ $roll->roll_no }} - {{ $roll->fabric ? $roll->fabric->fabric_code : '' }} ({{ $roll->gross_weight }} KG)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Inspected Length (Yds) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="1" name="inspected_length" class="form-control form-control-custom" required placeholder="e.g. 100">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Total Penalty Points <span class="text-danger">*</span></label>
                            <input type="number" min="0" name="total_penalty_points" class="form-control form-control-custom" required placeholder="e.g. 12">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Inspector Name <span class="text-danger">*</span></label>
                            <input type="text" name="inspector_name" class="form-control form-control-custom" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Defect Notes</label>
                            <textarea name="notes" class="form-control form-control-custom" rows="2" placeholder="e.g. Minor slubs at 25m, width uniform 72 inches"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue">Calculate 4-Point Score & Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
