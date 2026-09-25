@extends('layouts.app')

@section('title', 'Fabric Procurement')
@section('page_header_title', 'Fabric Procurement (PO)')
@section('page_header_subtitle', 'Stage 4: Fabric Requirement & Purchase Orders')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue" data-bs-toggle="modal" data-bs-target="#addFabricPoModal">
    <i class="bi bi-plus-lg"></i> Create Fabric PO
</button>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-custom-body pb-0 px-0">
        <div class="d-flex justify-content-between align-items-center px-4 pb-3">
            <h5 class="fw-bold mb-0 text-dark">Fabric Purchase Orders</h5>
            <span class="text-muted small">{{ $pos->count() }} PO(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>FABRIC PO NO</th>
                        <th>SALES ORDER</th>
                        <th>FABRIC MASTER</th>
                        <th>SUPPLIER NAME</th>
                        <th>REQUIRED QTY</th>
                        <th>EXPECTED DELIVERY</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pos as $po)
                        <tr>
                            <td class="fw-bold text-primary">{{ $po->po_no }}</td>
                            <td>{{ $po->salesOrder ? $po->salesOrder->sales_order_no : '-' }}</td>
                            <td>
                                <strong>{{ $po->fabric ? $po->fabric->fabric_code : '-' }}</strong>
                                <span class="small text-muted d-block">{{ $po->fabric ? $po->fabric->fabric_name : '' }}</span>
                            </td>
                            <td>{{ $po->supplier_name }}</td>
                            <td class="fw-bold">{{ number_format($po->required_qty, 2) }} {{ $po->unit }}</td>
                            <td>{{ \Carbon\Carbon::parse($po->delivery_date)->format('M d, Y') }}</td>
                            <td><span class="badge-active">{{ $po->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No fabric purchase orders issued yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addFabricPoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-bag-plus me-2"></i> Issue Fabric Purchase Order</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fabric-pos.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">PO Number <span class="text-danger">*</span></label>
                            <input type="text" name="po_no" class="form-control form-control-custom" required placeholder="e.g. FPO-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Sales Order <span class="text-danger">*</span></label>
                            <select name="sales_order_id" class="form-select form-select-custom" required>
                                <option value="">-- Select Sales Order --</option>
                                @foreach($salesOrders as $so)
                                    <option value="{{ $so->id }}">{{ $so->sales_order_no }} - {{ $so->style_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Fabric Master <span class="text-danger">*</span></label>
                            <select name="fabric_id" class="form-select form-select-custom" required>
                                <option value="">-- Select Fabric --</option>
                                @foreach($fabrics as $fab)
                                    <option value="{{ $fab->id }}">{{ $fab->fabric_code }} - {{ $fab->fabric_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" name="supplier_name" class="form-control form-control-custom" required placeholder="e.g. Acme Textile Mills">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Required Quantity <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.1" name="required_qty" class="form-control form-control-custom" required placeholder="e.g. 1250.50">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Unit <span class="text-danger">*</span></label>
                            <select name="unit" class="form-select form-select-custom" required>
                                <option value="KG" selected>KG</option>
                                <option value="Meter">Meter</option>
                                <option value="Yard">Yard</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Delivery Date <span class="text-danger">*</span></label>
                            <input type="date" name="delivery_date" class="form-control form-control-custom" value="{{ date('Y-m-d', strtotime('+10 days')) }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-custom" required>
                                <option value="Ordered" selected>Ordered</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue">Issue Fabric PO</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
