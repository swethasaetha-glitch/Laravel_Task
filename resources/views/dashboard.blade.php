@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_header_title', 'Production Dashboard')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')



@section('content')
<!-- Metric Summary Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Total Fabrics</div>
            <div class="metric-card-value">{{ $totalFabrics }}</div>
            <div class="metric-card-subtext">Fabrics in master catalog</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Fabric Groups</div>
            <div class="metric-card-value">{{ $totalFabricGroups }}</div>
            <div class="metric-card-subtext">Category groupings</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-card-label">Lay Models</div>
            <div class="metric-card-value">{{ $totalLayModels }}</div>
            <div class="metric-card-subtext">Cutting lay configurations</div>
        </div>
    </div>
</div>

<!-- Workflow Diagram Card -->
<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Garment Production Flow</h5>
        <p class="card-custom-subtitle">Connected module pipeline for textile master to cutting lay configuration.</p>

        <div class="row g-3 py-3 text-center">
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-3 h-100">
                    <i class="bi bi-aspect-ratio text-primary fs-1 mb-2 d-block"></i>
                    <h6 class="fw-bold">1. Fabric Master</h6>
                    <p class="small text-muted mb-2">Create & catalog raw textile fabrics with specifications.</p>
                    <a href="{{ route('fabrics.index') }}" class="btn btn-sm btn-outline-custom text-decoration-none">Manage Fabrics &rarr;</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-3 h-100">
                    <i class="bi bi-collection-fill text-success fs-1 mb-2 d-block"></i>
                    <h6 class="fw-bold">2. Fabric Group</h6>
                    <p class="small text-muted mb-2">Group fabrics belonging to production categories.</p>
                    <a href="{{ route('fabric-groups.index') }}" class="btn btn-sm btn-outline-custom text-decoration-none">Manage Groups &rarr;</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-3 h-100">
                    <i class="bi bi-bounding-box text-info fs-1 mb-2 d-block"></i>
                    <h6 class="fw-bold">3. Lay Model</h6>
                    <p class="small text-muted mb-2">Define laying parameters and marker dimensions.</p>
                    <a href="{{ route('lay-models.index') }}" class="btn btn-sm btn-outline-custom text-decoration-none">Manage Lays &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
