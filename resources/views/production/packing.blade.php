@extends('layouts.app')

@section('title', 'Packing & Dispatch')
@section('page_header_title', 'Packing & Finishing')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Cartons Packed</div>
            <div class="metric-card-value">142</div>
            <div class="metric-card-subtext">Packed today</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Total Pieces Packed</div>
            <div class="metric-card-value">2,840</div>
            <div class="metric-card-subtext">Ready for shipment</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Orders Ready</div>
            <div class="metric-card-value">3</div>
            <div class="metric-card-subtext">Awaiting export dispatch</div>
        </div>
    </div>
</div>

<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Packing & Export Finishing</h5>
        <p class="card-custom-subtitle">Garment poly-bagging, carton packing, and barcode labeling.</p>
        <div class="p-4 bg-light text-center rounded-3">
            <i class="bi bi-box-seam-fill text-primary display-4 mb-2"></i>
            <h6 class="fw-bold">Packing & Shipment Module Active</h6>
            <p class="text-muted small mb-0">Final stage of digital garment production workflow.</p>
        </div>
    </div>
</div>
@endsection
