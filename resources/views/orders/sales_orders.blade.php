@extends('layouts.app')

@section('title', 'Sales Orders')
@section('page_header_title', 'Sales Orders (ERP Entry)')
@section('page_header_subtitle', 'Stage 2: Garment Manufacturing Process Sequence')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue" data-bs-toggle="modal" data-bs-target="#addSalesOrderModal">
    <i class="bi bi-plus-lg"></i> Create Sales Order
</button>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-custom-body pb-0 px-0">
        <div class="d-flex justify-content-between align-items-center px-4 pb-3">
            <h5 class="fw-bold mb-0 text-dark">Sales Orders List</h5>
            <span class="text-muted small">{{ $salesOrders->count() }} sales order(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>SALES ORDER NO</th>
                        <th>BUYER PO</th>
                        <th>STYLE NO</th>
                        <th>GARMENT TYPE</th>
                        <th>COLORWAY</th>
                        <th>SIZE RATIO</th>
                        <th>ORDER QTY</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesOrders as $so)
                        <tr>
                            <td class="fw-bold text-primary">{{ $so->sales_order_no }}</td>
                            <td>{{ $so->buyerOrder ? $so->buyerOrder->po_number . ' (' . $so->buyerOrder->buyer_name . ')' : '-' }}</td>
                            <td class="fw-bold">{{ $so->style_no }}</td>
                            <td>{{ $so->garment_type }}</td>
                            <td>{{ $so->colorway }}</td>
                            <td><code>{{ $so->size_ratio ?: 'S:1 M:2 L:2 XL:1' }}</code></td>
                            <td class="fw-bold">{{ number_format($so->order_qty) }}</td>
                            <td><span class="badge-active">{{ $so->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No sales orders created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addSalesOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-receipt me-2"></i> Add Sales Order (ERP Entry)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sales-orders.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Sales Order No <span class="text-danger">*</span></label>
                            <input type="text" name="sales_order_no" class="form-control form-control-custom" required placeholder="e.g. SO-2026-101">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Buyer PO <span class="text-danger">*</span></label>
                            <select name="buyer_order_id" class="form-select form-select-custom" required>
                                <option value="">-- Select Buyer PO --</option>
                                @foreach($buyerOrders as $bOrder)
                                    <option value="{{ $bOrder->id }}">{{ $bOrder->po_number }} - {{ $bOrder->buyer_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Style No <span class="text-danger">*</span></label>
                            <input type="text" name="style_no" class="form-control form-control-custom" required placeholder="e.g. ST-789">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Garment Type <span class="text-danger">*</span></label>
                            <input type="text" name="garment_type" class="form-control form-control-custom" required placeholder="e.g. Men's Polo">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Colorway <span class="text-danger">*</span></label>
                            <input type="text" name="colorway" class="form-control form-control-custom" required placeholder="e.g. Black / White">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Size Ratio Breakdown</label>
                            <input type="text" name="size_ratio" class="form-control form-control-custom" placeholder="e.g. S:1, M:2, L:2, XL:1">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Order Qty (Pcs) <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="order_qty" class="form-control form-control-custom" required placeholder="e.g. 2500">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-custom" required>
                                <option value="In Production" selected>In Production</option>
                                <option value="Planned">Planned</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue">Save Sales Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
