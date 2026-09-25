@extends('layouts.app')

@section('title', 'Lay Planning & Slips')
@section('page_header_title', 'Lay Planning & Lay Slips Execution')
@section('page_header_subtitle', 'Final Cut Room Stage: Marker Efficiency, Fabric Spreading & Lay Completion')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue" data-bs-toggle="modal" data-bs-target="#addLaySlipModal">
    <i class="bi bi-grid-3x3-gap"></i> Issue Lay Slip (Complete Lay)
</button>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-custom-body pb-0 px-0">
        <div class="d-flex justify-content-between align-items-center px-4 pb-3">
            <h5 class="fw-bold mb-0 text-dark">Lay Slips & Completed Lays</h5>
            <span class="text-muted small">{{ $laySlips->count() }} lay slip(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>LAY SLIP NO</th>
                        <th>PLAN NO</th>
                        <th>LAY MODEL</th>
                        <th>FABRIC GROUP</th>
                        <th>TABLE NO</th>
                        <th>SPREADER OPERATOR</th>
                        <th>PLIES</th>
                        <th>LAY LENGTH</th>
                        <th>MARKER EFFICIENCY</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laySlips as $slip)
                        <tr>
                            <td class="fw-bold text-primary">{{ $slip->lay_slip_no }}</td>
                            <td>{{ $slip->productionPlan ? $slip->productionPlan->plan_no : '-' }}</td>
                            <td>
                                <strong>{{ $slip->layModel ? $slip->layModel->lay_model_code : '-' }}</strong>
                                <span class="small text-muted d-block">{{ $slip->layModel ? $slip->layModel->lay_model_name : '' }}</span>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $slip->fabricGroup ? $slip->fabricGroup->group_name : '-' }}</span></td>
                            <td><span class="badge bg-info text-white">{{ $slip->table_no }}</span></td>
                            <td>{{ $slip->spreader_operator }}</td>
                            <td class="fw-bold">{{ $slip->total_plies }} plies</td>
                            <td>{{ $slip->lay_length }} yds</td>
                            <td class="fw-bold text-success">{{ $slip->marker_efficiency_pct }}%</td>
                            <td><span class="badge-active">{{ $slip->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">No lay slips generated yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addLaySlipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-scissors me-2"></i> Issue Lay Slip & Execute Lay Completion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('lay-slips.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Lay Slip No <span class="text-danger">*</span></label>
                            <input type="text" name="lay_slip_no" class="form-control form-control-custom" required placeholder="e.g. LS-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Production Plan <span class="text-danger">*</span></label>
                            <select name="production_plan_id" class="form-select form-select-custom" required>
                                <option value="">-- Select Production Plan --</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->plan_no }} - {{ $plan->salesOrder ? $plan->salesOrder->style_no : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Lay Model <span class="text-danger">*</span></label>
                            <select name="lay_model_id" class="form-select form-select-custom" required>
                                <option value="">-- Select Lay Model --</option>
                                @foreach($layModels as $lm)
                                    <option value="{{ $lm->id }}">{{ $lm->lay_model_code }} - {{ $lm->lay_model_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Fabric Group <span class="text-danger">*</span></label>
                            <select name="fabric_group_id" class="form-select form-select-custom" required>
                                <option value="">-- Select Fabric Group --</option>
                                @foreach($fabricGroups as $fg)
                                    <option value="{{ $fg->id }}">{{ $fg->group_code }} - {{ $fg->group_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Table No <span class="text-danger">*</span></label>
                            <input type="text" name="table_no" class="form-control form-control-custom" required placeholder="e.g. Table 03">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Spreader Operator <span class="text-danger">*</span></label>
                            <input type="text" name="spreader_operator" class="form-control form-control-custom" required placeholder="e.g. Robert / Team A">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Total Plies <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="total_plies" class="form-control form-control-custom" value="50" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Lay Length (Yds) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.1" name="lay_length" class="form-control form-control-custom" value="12.50" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Marker Efficiency %</label>
                            <input type="number" step="0.01" min="50" max="100" name="marker_efficiency_pct" class="form-control form-control-custom" value="87.50">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-custom" required>
                                <option value="Lay Completed" selected>Lay Completed</option>
                                <option value="In Spreading">In Spreading</option>
                                <option value="Planned">Planned</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue">Complete Lay Process & Issue Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
