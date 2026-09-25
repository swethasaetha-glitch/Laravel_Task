@extends('layouts.app')

@section('title', 'Cutting Management')
@section('page_header_title', 'Cutting Production')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')

@section('top_header_action')
<a href="#" class="btn btn-primary-blue">
    <i class="bi bi-scissors"></i> Start New Cut Order
</a>
@endsection

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Active Lay Orders</div>
            <div class="metric-card-value">5</div>
            <div class="metric-card-subtext">Currently on cutting tables</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Total Cut Pieces</div>
            <div class="metric-card-value">12,450</div>
            <div class="metric-card-subtext">Cut this week</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Cutting Efficiency</div>
            <div class="metric-card-value">96.8%</div>
            <div class="metric-card-subtext">Based on marker utilization</div>
        </div>
    </div>
</div>

<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Cutting Floor Operations</h5>
        <p class="card-custom-subtitle">Manage fabric spreads, lay cutting, and bundle ticket generation.</p>
        <div class="p-4 bg-light text-center rounded-3">
            <i class="bi bi-scissors text-primary display-4 mb-2"></i>
            <h6 class="fw-bold">Cutting Operations Module Ready</h6>
            <p class="text-muted small mb-0">Linked with Fabric Master, Fabric Groups, and Lay Models.</p>
        </div>
    </div>
</div>
@endsection
