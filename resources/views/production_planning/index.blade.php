@extends('layouts.app')

@section('title', 'Production Planning')
@section('page_header_title', 'Production Planning & Allocation')
@section('page_header_subtitle', 'Stage 3: Garment Manufacturing Process Sequence')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue" data-bs-toggle="modal" data-bs-target="#addPlanModal">
    <i class="bi bi-plus-lg"></i> Generate Production Plan
</button>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-custom-body pb-0 px-0">
        <div class="d-flex justify-content-between align-items-center px-4 pb-3">
            <h5 class="fw-bold mb-0 text-dark">Production Plans</h5>
            <span class="text-muted small">{{ $plans->count() }} plan(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>PLAN NO</th>
                        <th>SALES ORDER</th>
                        <th>BUYER / STYLE</th>
                        <th>START DATE</th>
                        <th>END DATE</th>
                        <th>DAILY TARGET</th>
                        <th>LINE ALLOCATION</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr>
                            <td class="fw-bold text-primary">{{ $plan->plan_no }}</td>
                            <td>{{ $plan->salesOrder ? $plan->salesOrder->sales_order_no : '-' }}</td>
                            <td>
                                <strong>{{ $plan->salesOrder && $plan->salesOrder->buyerOrder ? $plan->salesOrder->buyerOrder->buyer_name : '-' }}</strong>
                                <span class="small text-muted d-block">{{ $plan->salesOrder ? $plan->salesOrder->style_no : '' }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($plan->planned_start_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($plan->planned_end_date)->format('M d, Y') }}</td>
                            <td class="fw-bold">{{ number_format($plan->target_daily_qty) }} pcs/day</td>
                            <td><span class="badge bg-info text-white">{{ $plan->line_allocation ?: 'Line 1 & 2' }}</span></td>
                            <td><span class="badge-active">{{ $plan->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No production plans generated yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addPlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-calendar-event me-2"></i> Generate Production Plan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('production-plans.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Plan No <span class="text-danger">*</span></label>
                            <input type="text" name="plan_no" class="form-control form-control-custom" required placeholder="e.g. PP-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Sales Order <span class="text-danger">*</span></label>
                            <select name="sales_order_id" class="form-select form-select-custom" required>
                                <option value="">-- Select Sales Order --</option>
                                @foreach($salesOrders as $so)
                                    <option value="{{ $so->id }}">{{ $so->sales_order_no }} - {{ $so->style_no }} ({{ number_format($so->order_qty) }} pcs)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Planned Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="planned_start_date" class="form-control form-control-custom" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Planned End Date <span class="text-danger">*</span></label>
                            <input type="date" name="planned_end_date" class="form-control form-control-custom" value="{{ date('Y-m-d', strtotime('+15 days')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Target Daily Qty (Pcs) <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="target_daily_qty" class="form-control form-control-custom" required placeholder="e.g. 500">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Line Allocation</label>
                            <input type="text" name="line_allocation" class="form-control form-control-custom" placeholder="e.g. Sewing Line 1 & Line 2">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-custom" required>
                                <option value="Approved" selected>Approved</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue">Save & Approve Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
