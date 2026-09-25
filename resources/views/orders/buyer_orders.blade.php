@extends('layouts.app')

@section('title', 'Buyer Orders')
@section('page_header_title', 'Buyer Orders (PO Master)')
@section('page_header_subtitle', 'Stage 1: Garment Manufacturing Process Sequence')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue" data-bs-toggle="modal" data-bs-target="#addBuyerOrderModal">
    <i class="bi bi-plus-lg"></i> Create Buyer Order
</button>
@endsection

@section('content')
<div class="card-custom">
    <div class="card-custom-body pb-0 px-0">
        <div class="d-flex justify-content-between align-items-center px-4 pb-3">
            <h5 class="fw-bold mb-0 text-dark">Buyer Orders List</h5>
            <span class="text-muted small">{{ $buyerOrders->count() }} order(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>PO NUMBER</th>
                        <th>BUYER NAME</th>
                        <th>ORDER DATE</th>
                        <th>DELIVERY DATE</th>
                        <th>TOTAL QTY (PCS)</th>
                        <th>CONNECTED SALES ORDERS</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buyerOrders as $order)
                        <tr>
                            <td class="fw-bold text-primary">{{ $order->po_number }}</td>
                            <td class="fw-semibold">{{ $order->buyer_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}</td>
                            <td class="fw-bold">{{ number_format($order->total_garment_qty) }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $order->salesOrders->count() }} Sales Order(s)</span>
                            </td>
                            <td><span class="badge-active">{{ $order->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No buyer orders created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addBuyerOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-cart-check me-2"></i> Add Buyer Order</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('buyer-orders.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Buyer Name <span class="text-danger">*</span></label>
                            <input type="text" name="buyer_name" class="form-control form-control-custom" required placeholder="e.g. Nike International">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">PO Number <span class="text-danger">*</span></label>
                            <input type="text" name="po_number" class="form-control form-control-custom" required placeholder="e.g. PO-NK-2026-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Order Date <span class="text-danger">*</span></label>
                            <input type="date" name="order_date" class="form-control form-control-custom" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Delivery Date <span class="text-danger">*</span></label>
                            <input type="date" name="delivery_date" class="form-control form-control-custom" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Total Garment Qty (Pcs) <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="total_garment_qty" class="form-control form-control-custom" required placeholder="e.g. 5000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-custom" required>
                                <option value="Confirmed" selected>Confirmed</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue">Save Buyer Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
