@extends('layouts.app')

@section('title', 'Quality Control')
@section('page_header_title', 'Quality Control & Inspection')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Pass Rate</div>
            <div class="metric-card-value">98.4%</div>
            <div class="metric-card-subtext">First time pass rate</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Inspected Pieces</div>
            <div class="metric-card-value">2,850</div>
            <div class="metric-card-subtext">Pieces checked today</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Defects Found</div>
            <div class="metric-card-value">46</div>
            <div class="metric-card-subtext">Sent for alteration</div>
        </div>
    </div>
</div>

<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Quality Assurance & Audit</h5>
        <p class="card-custom-subtitle">Inline and end-of-line quality inspections.</p>
        <div class="p-4 bg-light text-center rounded-3">
            <i class="bi bi-check-circle-fill text-success display-4 mb-2"></i>
            <h6 class="fw-bold">Quality Inspection Module Active</h6>
            <p class="text-muted small mb-0">Tracks defect classification and garment quality standards.</p>
        </div>
    </div>
</div>
@endsection
