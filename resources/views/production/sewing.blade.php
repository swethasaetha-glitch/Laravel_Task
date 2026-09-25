@extends('layouts.app')

@section('title', 'Sewing Operations')
@section('page_header_title', 'Sewing Line Tracking')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Active Lines</div>
            <div class="metric-card-value">8</div>
            <div class="metric-card-subtext">Assembly lines running</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Daily Target</div>
            <div class="metric-card-value">3,500</div>
            <div class="metric-card-subtext">Target pieces</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Line Output</div>
            <div class="metric-card-value">2,890</div>
            <div class="metric-card-subtext">Completed pieces today</div>
        </div>
    </div>
</div>

<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Sewing Assembly Lines</h5>
        <p class="card-custom-subtitle">Real-time tracking for sewing line production and operator efficiency.</p>
        <div class="p-4 bg-light text-center rounded-3">
            <i class="bi bi-gear-wide-connected text-primary display-4 mb-2"></i>
            <h6 class="fw-bold">Sewing Tracking Module Active</h6>
            <p class="text-muted small mb-0">Monitors bundle flow from cutting to sewing assembly.</p>
        </div>
    </div>
</div>
@endsection
