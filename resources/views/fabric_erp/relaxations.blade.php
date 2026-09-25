@extends('layouts.app')

@section('title', 'Fabric Relaxation')
@section('page_header_title', 'Fabric Relaxation & Shrinkage Log')
@section('page_header_subtitle', 'Stage 7: Pre-Cutting Fabric Relaxation Hours & Shrinkage Test')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue" data-bs-toggle="modal" data-bs-target="#addRelaxationModal">
    <i class="bi bi-clock-history"></i> Log Fabric Relaxation
</button>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-custom-body pb-0 px-0">
        <div class="d-flex justify-content-between align-items-center px-4 pb-3">
            <h5 class="fw-bold mb-0 text-dark">Fabric Relaxation Records</h5>
            <span class="text-muted small">{{ $relaxations->count() }} record(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>RELAXATION NO</th>
                        <th>ROLL NO</th>
                        <th>FABRIC</th>
                        <th>START TIME</th>
                        <th>END TIME</th>
                        <th>REQUIRED HOURS</th>
                        <th>SHRINKAGE %</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($relaxations as $rel)
                        <tr>
                            <td class="fw-bold text-primary">{{ $rel->relaxation_no }}</td>
                            <td class="fw-bold">{{ $rel->fabricRoll ? $rel->fabricRoll->roll_no : '-' }}</td>
                            <td>{{ $rel->fabricRoll && $rel->fabricRoll->fabric ? $rel->fabricRoll->fabric->fabric_name : '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($rel->start_time)->format('M d, H:i') }}</td>
                            <td>{{ $rel->end_time ? \Carbon\Carbon::parse($rel->end_time)->format('M d, H:i') : '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $rel->required_hours }} Hours</span></td>
                            <td class="fw-bold text-info">{{ $rel->shrinkage_pct }}%</td>
                            <td><span class="badge-active">{{ $rel->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No fabric relaxation logs recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addRelaxationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-clock-history me-2"></i> Log Fabric Relaxation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fabric-relaxations.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Relaxation No <span class="text-danger">*</span></label>
                            <input type="text" name="relaxation_no" class="form-control form-control-custom" required placeholder="e.g. REL-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Passed Fabric Roll <span class="text-danger">*</span></label>
                            <select name="fabric_roll_id" class="form-select form-select-custom" required>
                                <option value="">-- Select Passed Roll --</option>
                                @foreach($passedRolls as $roll)
                                    <option value="{{ $roll->id }}">{{ $roll->roll_no }} - {{ $roll->fabric ? $roll->fabric->fabric_code : '' }} ({{ $roll->shade }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Start Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="start_time" class="form-control form-control-custom" value="{{ date('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Required Hours <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="required_hours" class="form-control form-control-custom" value="24" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Shrinkage %</label>
                            <input type="number" step="0.01" min="0" name="shrinkage_pct" class="form-control form-control-custom" value="1.50">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue">Log Relaxation & Mark Ready</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
