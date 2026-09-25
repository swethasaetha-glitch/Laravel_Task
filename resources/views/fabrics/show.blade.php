@extends('layouts.app')

@section('title', 'Fabric Details')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('fabrics.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left"></i> Back to Fabrics
        </a>
        <h2 class="fw-bold mt-2 mb-0">{{ $fabric->fabric_name }} ({{ $fabric->fabric_code }})</h2>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('fabrics.edit', $fabric) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit Fabric
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-info-circle text-primary me-2"></i> Fabric Details</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <span class="text-muted d-block small">Fabric Code</span>
                        <span class="fw-bold fs-6">{{ $fabric->fabric_code }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted d-block small">Fabric Name</span>
                        <span class="fw-bold fs-6">{{ $fabric->fabric_name }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted d-block small">Type</span>
                        <span class="badge bg-secondary fs-6">{{ $fabric->fabric_type }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted d-block small">Status</span>
                        @if($fabric->status === 'Active')
                            <span class="badge badge-active fs-6">Active</span>
                        @else
                            <span class="badge badge-inactive fs-6">Inactive</span>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted d-block small">Composition</span>
                        <span>{{ $fabric->composition ?: '-' }}</span>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted d-block small">Color</span>
                        <span>{{ $fabric->color ?: '-' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block small">GSM</span>
                        <span>{{ $fabric->gsm ?: '-' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block small">Width</span>
                        <span>{{ $fabric->width ?: '-' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="text-muted d-block small">Unit</span>
                        <span>{{ $fabric->unit ?: '-' }}</span>
                    </div>
                    <div class="col-12">
                        <span class="text-muted d-block small">Description</span>
                        <p class="mb-0">{{ $fabric->description ?: 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Groups associated -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-collection text-success me-2"></i> Associated Fabric Groups</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($fabric->groups as $group)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('fabric-groups.show', $group) }}" class="fw-bold text-decoration-none text-dark">
                                    {{ $group->group_name }}
                                </a>
                                <div class="small text-muted">{{ $group->group_code }}</div>
                            </div>
                            <span class="badge bg-light text-dark border">{{ $group->status }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center py-3">Not assigned to any group</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Lay Models associated -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-grid-3x3-gap text-info me-2"></i> Associated Lay Models</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($fabric->layModels as $lay)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('lay-models.show', $lay) }}" class="fw-bold text-decoration-none text-dark">
                                    {{ $lay->lay_model_name }}
                                </a>
                                <div class="small text-muted">{{ $lay->lay_model_code }}</div>
                            </div>
                            <span class="badge bg-light text-dark border">{{ $lay->status }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center py-3">Not used in any lay model</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
