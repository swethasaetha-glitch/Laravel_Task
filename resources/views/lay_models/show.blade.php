@extends('layouts.app')

@section('title', 'Lay Model Details')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('lay-models.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left"></i> Back to Lay Models
        </a>
        <h2 class="fw-bold mt-2 mb-0">{{ $layModel->lay_model_name }}</h2>
        <span class="badge bg-secondary fs-6 mt-1">{{ $layModel->lay_model_code }}</span>
        @if($layModel->status === 'Active')
            <span class="badge badge-active fs-6 ms-1">Active</span>
        @else
            <span class="badge badge-inactive fs-6 ms-1">Inactive</span>
        @endif
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('lay-models.edit', $layModel) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit Lay Model
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-grid-3x3-gap text-info me-2"></i> Lay Parameters & Marker Specifications</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <span class="text-muted d-block small">Lay Model Code</span>
                        <span class="fw-bold fs-6">{{ $layModel->lay_model_code }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted d-block small">Lay Model Name</span>
                        <span class="fw-bold fs-6">{{ $layModel->lay_model_name }}</span>
                    </div>

                    <div class="col-sm-4">
                        <span class="text-muted d-block small">Lay Length</span>
                        <span class="fw-semibold fs-6">{{ $layModel->lay_length }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block small">Lay Width</span>
                        <span class="fw-semibold fs-6">{{ $layModel->lay_width }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block small">Number of Plies</span>
                        <span class="badge bg-info text-white fs-6">{{ $layModel->number_of_plies }} plies</span>
                    </div>

                    <div class="col-sm-4">
                        <span class="text-muted d-block small">Garment Size</span>
                        <span class="fw-semibold fs-6">{{ $layModel->garment_size ?: '-' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block small">Marker Length</span>
                        <span class="fw-semibold fs-6">{{ $layModel->marker_length ?: '-' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block small">Marker Width</span>
                        <span class="fw-semibold fs-6">{{ $layModel->marker_width ?: '-' }}</span>
                    </div>

                    <div class="col-12">
                        <span class="text-muted d-block small">Description</span>
                        <p class="mb-0">{{ $layModel->description ?: 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Relationship hierarchy display -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-diagram-3 text-primary me-2"></i> Relationship Hierarchy</h6>
            </div>
            <div class="card-body">
                <div class="p-3 bg-light rounded">
                    <div class="mb-3">
                        <span class="badge bg-success text-uppercase">1. Fabric Group</span>
                        <h6 class="fw-bold mt-1 mb-0">
                            @if($layModel->fabricGroup)
                                <a href="{{ route('fabric-groups.show', $layModel->fabricGroup) }}" class="text-decoration-none text-dark">
                                    {{ $layModel->fabricGroup->group_name }} ({{ $layModel->fabricGroup->group_code }})
                                </a>
                            @else
                                N/A
                            @endif
                        </h6>
                    </div>
                    <div class="text-center my-1 text-muted">
                        <i class="bi bi-arrow-down fs-5"></i>
                    </div>
                    <div>
                        <span class="badge bg-primary text-uppercase">2. Fabric</span>
                        <h6 class="fw-bold mt-1 mb-0">
                            @if($layModel->fabric)
                                <a href="{{ route('fabrics.show', $layModel->fabric) }}" class="text-decoration-none text-dark">
                                    {{ $layModel->fabric->fabric_name }} ({{ $layModel->fabric->fabric_code }})
                                </a>
                            @else
                                N/A
                            @endif
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
