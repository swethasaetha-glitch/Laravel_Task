@extends('layouts.app')

@section('title', 'Production Bundles')
@section('page_header_title', 'Production Bundles')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue" data-bs-toggle="modal" data-bs-target="#addBundleModal">
    <i class="bi bi-plus-lg"></i> Add Production Bundle
</button>
@endsection

@section('content')
<!-- Search & Filter Card -->
<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Search & Filter Production Bundles</h5>
        <p class="card-custom-subtitle">Search and filter bundles based on production details.</p>

        <form method="GET" action="{{ route('production.bundles') }}">
            <div class="row g-3 mb-3">
                <div class="col-md-5">
                    <label class="form-label small fw-bold text-muted">Search</label>
                    <input type="text" name="search" class="form-control form-control-custom" placeholder="Bundle No, Buyer, Style No, Order No..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">Status</label>
                    <select name="status" class="form-select form-select-custom">
                        <option value="">All Statuses</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">Garment Type</label>
                    <select name="garment" class="form-select form-select-custom">
                        <option value="">All Garments</option>
                        <option value="Men's Polo" {{ request('garment') == "Men's Polo" ? 'selected' : '' }}>Men's Polo</option>
                        <option value="T-Shirt" {{ request('garment') == 'T-Shirt' ? 'selected' : '' }}>T-Shirt</option>
                        <option value="Jacket" {{ request('garment') == 'Jacket' ? 'selected' : '' }}>Jacket</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Quantity</label>
                    <select name="quantity" class="form-select form-select-custom">
                        <option value="">Default</option>
                        <option value="high" {{ request('quantity') == 'high' ? 'selected' : '' }}>High to Low</option>
                        <option value="low" {{ request('quantity') == 'low' ? 'selected' : '' }}>Low to High</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-blue">
                    Search & Filter
                </button>
                @if(request('search') || request('status') || request('garment') || request('quantity'))
                    <a href="{{ route('production.bundles') }}" class="btn btn-outline-custom text-decoration-none">
                        Clear Filters
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Metric Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Total Bundles</div>
            <div class="metric-card-value">{{ number_format($totalBundles) }}</div>
            <div class="metric-card-subtext">Production bundles found</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Total Quantity</div>
            <div class="metric-card-value">{{ number_format($totalQuantity) }}</div>
            <div class="metric-card-subtext">Quantity on current page</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Completed Quantity</div>
            <div class="metric-card-value">{{ number_format($completedQuantity) }}</div>
            <div class="metric-card-subtext">Completed pieces</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Rejected Quantity</div>
            <div class="metric-card-value">{{ number_format($rejectedQuantity) }}</div>
            <div class="metric-card-subtext">Rejected pieces</div>
        </div>
    </div>
</div>

<!-- Production Bundle Table List -->
<div class="card-custom">
    <div class="card-custom-body pb-0 px-0">
        <div class="d-flex justify-content-between align-items-center px-4 pb-3">
            <h5 class="fw-bold mb-0 text-dark">Production Bundle List</h5>
            <span class="text-muted small">{{ $bundles->count() }} bundle(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>BUNDLE NO</th>
                        <th>BUYER</th>
                        <th>STYLE NO</th>
                        <th>ORDER NO</th>
                        <th>GARMENT</th>
                        <th>COLOR</th>
                        <th>SIZE</th>
                        <th>TOTAL QTY</th>
                        <th>COMPLETED</th>
                        <th>REJECTED</th>
                        <th>STATUS</th>
                        <th class="text-end">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bundles as $bundle)
                        <tr>
                            <td class="fw-bold">{{ $bundle->bundle_no }}</td>
                            <td>{{ $bundle->buyer }}</td>
                            <td>{{ $bundle->style_no }}</td>
                            <td>{{ $bundle->order_no }}</td>
                            <td>{{ $bundle->garment }}</td>
                            <td>{{ $bundle->color ?: '-' }}</td>
                            <td>{{ $bundle->size ?: '-' }}</td>
                            <td class="fw-bold">{{ number_format($bundle->total_qty) }}</td>
                            <td class="text-success fw-bold">{{ number_format($bundle->completed_qty) }}</td>
                            <td class="{{ $bundle->rejected_qty > 0 ? 'text-danger fw-bold' : '' }}">{{ number_format($bundle->rejected_qty) }}</td>
                            <td>
                                @if($bundle->status === 'Active')
                                    <span class="badge-active">Active</span>
                                @elseif($bundle->status === 'Completed')
                                    <span class="badge bg-success text-white px-2 py-1 rounded-pill small">Completed</span>
                                @else
                                    <span class="badge-inactive">Pending</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form action="{{ route('production.bundles.destroy', $bundle) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete bundle {{ $bundle->bundle_no }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-4 text-muted">
                                No production bundles found. Click <strong>+ Add Production Bundle</strong> to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Production Bundle Modal -->
<div class="modal fade" id="addBundleModal" tabindex="-1" aria-labelledby="addBundleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="addBundleModalLabel"><i class="bi bi-plus-circle me-2"></i> Add Production Bundle</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('production.bundles.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="bundle_no" class="form-label fw-bold small">Bundle No <span class="text-danger">*</span></label>
                            <input type="text" name="bundle_no" id="bundle_no" class="form-control form-control-custom" required placeholder="e.g. BND-003">
                        </div>
                        <div class="col-md-4">
                            <label for="buyer" class="form-label fw-bold small">Buyer <span class="text-danger">*</span></label>
                            <input type="text" name="buyer" id="buyer" class="form-control form-control-custom" required placeholder="e.g. Puma">
                        </div>
                        <div class="col-md-4">
                            <label for="style_no" class="form-label fw-bold small">Style No <span class="text-danger">*</span></label>
                            <input type="text" name="style_no" id="style_no" class="form-control form-control-custom" required placeholder="e.g. ST-123">
                        </div>

                        <div class="col-md-4">
                            <label for="order_no" class="form-label fw-bold small">Order No <span class="text-danger">*</span></label>
                            <input type="text" name="order_no" id="order_no" class="form-control form-control-custom" required placeholder="e.g. ORD-103">
                        </div>
                        <div class="col-md-4">
                            <label for="garment" class="form-label fw-bold small">Garment Type <span class="text-danger">*</span></label>
                            <input type="text" name="garment" id="garment" class="form-control form-control-custom" required placeholder="e.g. Men's Polo / T-Shirt">
                        </div>
                        <div class="col-md-4">
                            <label for="color" class="form-label fw-bold small">Color</label>
                            <input type="text" name="color" id="color" class="form-control form-control-custom" placeholder="e.g. Navy Blue">
                        </div>

                        <div class="col-md-4">
                            <label for="size" class="form-label fw-bold small">Size</label>
                            <input type="text" name="size" id="size" class="form-control form-control-custom" placeholder="e.g. L / XL">
                        </div>
                        <div class="col-md-4">
                            <label for="total_qty" class="form-label fw-bold small">Total Quantity <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="total_qty" id="total_qty" class="form-control form-control-custom" required placeholder="e.g. 500">
                        </div>
                        <div class="col-md-4">
                            <label for="completed_qty" class="form-label fw-bold small">Completed Qty</label>
                            <input type="number" min="0" name="completed_qty" id="completed_qty" class="form-control form-control-custom" value="0" placeholder="0">
                        </div>

                        <div class="col-md-6">
                            <label for="rejected_qty" class="form-label fw-bold small">Rejected Qty</label>
                            <input type="number" min="0" name="rejected_qty" id="rejected_qty" class="form-control form-control-custom" value="0" placeholder="0">
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select form-select-custom" required>
                                <option value="Active" selected>Active</option>
                                <option value="Completed">Completed</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue">
                        <i class="bi bi-save me-1"></i> Save Bundle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
