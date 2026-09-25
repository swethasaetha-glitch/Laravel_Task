@extends('layouts.app')

@section('title', 'Fabric Group Details')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('fabric-groups.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left"></i> Back to Fabric Groups
        </a>
        <h2 class="fw-bold mt-2 mb-0">{{ $fabricGroup->group_name }}</h2>
        <span class="badge bg-secondary fs-6 mt-1">{{ $fabricGroup->group_code }}</span>
        @if($fabricGroup->status === 'Active')
            <span class="badge badge-active fs-6 ms-1">Active</span>
        @else
            <span class="badge badge-inactive fs-6 ms-1">Inactive</span>
        @endif
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('fabric-groups.edit', $fabricGroup) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit Group
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Group Overview -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold text-uppercase text-muted small mb-2">Description</h6>
                <p class="mb-0 fs-6">{{ $fabricGroup->description ?: 'No description provided for this group.' }}</p>
            </div>
        </div>
    </div>

    <!-- Assigned Fabrics Table -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="bi bi-layers text-primary me-2"></i> Fabrics in this Group</h5>
                <span class="badge bg-primary rounded-pill">{{ $fabricGroup->fabrics->count() }} fabrics</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Fabric Name</th>
                            <th>GSM</th>
                            <th>Width</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fabricGroup->fabrics as $fabric)
                            <tr>
                                <td><span class="fw-bold text-dark">{{ $fabric->fabric_code }}</span></td>
                                <td>{{ $fabric->fabric_name }}</td>
                                <td>{{ $fabric->gsm ?: '-' }}</td>
                                <td>{{ $fabric->width ?: '-' }}</td>
                                <td>
                                    @if($fabric->status === 'Active')
                                        <span class="badge badge-active">Active</span>
                                    @else
                                        <span class="badge badge-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('fabric-groups.remove-fabric', [$fabricGroup, $fabric]) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove {{ $fabric->fabric_code }} from this group?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Remove from Group">
                                            <i class="bi bi-x-circle me-1"></i> Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No fabrics connected to this group.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Add Fabrics Form -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-plus-circle text-success me-2"></i> Add Fabrics to Group</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('fabric-groups.add-fabrics', $fabricGroup) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small text-muted">Select Available Fabrics</label>
                        @php
                            $assignedIds = $fabricGroup->fabrics->pluck('id')->toArray();
                            $unassignedFabrics = $allFabrics->reject(fn($f) => in_array($f->id, $assignedIds));
                        @endphp
                        <select name="fabrics[]" class="form-select" multiple size="6" required>
                            @forelse($unassignedFabrics as $unassigned)
                                <option value="{{ $unassigned->id }}">
                                    {{ $unassigned->fabric_code }} - {{ $unassigned->fabric_name }}
                                </option>
                            @empty
                                <option disabled>All active fabrics are already in this group</option>
                            @endforelse
                        </select>
                        <div class="form-text">Hold Ctrl / Cmd to select multiple.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100" {{ $unassignedFabrics->isEmpty() ? 'disabled' : '' }}>
                        <i class="bi bi-plus-lg me-1"></i> Add Selected Fabrics
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
