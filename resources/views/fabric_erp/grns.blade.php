@extends('layouts.app')

@section('title', 'Fabric Receiving & GRN')
@section('page_header_title', 'Fabric Receiving & GRN')
@section('page_header_subtitle', 'Stage 5: Goods Receipt Note & Fabric Roll Store Registration')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue" data-bs-toggle="modal" data-bs-target="#addGrnModal">
    <i class="bi bi-box-arrow-in-down"></i> Receive Fabric (GRN)
</button>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-custom-body pb-0 px-0">
        <div class="d-flex justify-content-between align-items-center px-4 pb-3">
            <h5 class="fw-bold mb-0 text-dark">Goods Receipt Notes (GRN)</h5>
            <span class="text-muted small">{{ $grns->count() }} GRN(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>GRN NO</th>
                        <th>FABRIC PO NO</th>
                        <th>SUPPLIER INVOICE</th>
                        <th>RECEIVED DATE</th>
                        <th>TOTAL ROLLS</th>
                        <th>RECEIVED QTY</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grns as $grn)
                        <tr>
                            <td class="fw-bold text-primary">{{ $grn->grn_no }}</td>
                            <td>{{ $grn->fabricPo ? $grn->fabricPo->po_no : '-' }}</td>
                            <td>{{ $grn->supplier_invoice_no }}</td>
                            <td>{{ \Carbon\Carbon::parse($grn->received_date)->format('M d, Y') }}</td>
                            <td><span class="badge bg-info text-white">{{ $grn->total_rolls_received }} Roll(s)</span></td>
                            <td class="fw-bold">{{ number_format($grn->received_qty, 2) }} {{ $grn->fabricPo ? $grn->fabricPo->unit : 'KG' }}</td>
                            <td><span class="badge-active">{{ $grn->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No GRN receipts registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addGrnModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-box-arrow-in-down me-2"></i> Create GRN (Goods Receipt Note)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fabric-grns.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">GRN No <span class="text-danger">*</span></label>
                            <input type="text" name="grn_no" class="form-control form-control-custom" required placeholder="e.g. GRN-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Fabric PO <span class="text-danger">*</span></label>
                            <select name="fabric_po_id" class="form-select form-select-custom" required>
                                <option value="">-- Select Fabric PO --</option>
                                @foreach($pos as $po)
                                    <option value="{{ $po->id }}">{{ $po->po_no }} - {{ $po->supplier_name }} ({{ $po->required_qty }} {{ $po->unit }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Supplier Invoice No <span class="text-danger">*</span></label>
                            <input type="text" name="supplier_invoice_no" class="form-control form-control-custom" required placeholder="e.g. INV-98765">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Received Date <span class="text-danger">*</span></label>
                            <input type="date" name="received_date" class="form-control form-control-custom" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Total Rolls Received <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="total_rolls_received" class="form-control form-control-custom" required placeholder="e.g. 10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Received Qty (Net Weight) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.1" name="received_qty" class="form-control form-control-custom" required placeholder="e.g. 1250.00">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-custom" required>
                                <option value="Received" selected>Received & Store Stored</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue">Receive & Generate Roll Tags</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
