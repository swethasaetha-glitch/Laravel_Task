@extends('layouts.app')

@section('title', 'Lay Models')
@section('page_header_title', 'Lay Models')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')

@section('top_header_action')
<a href="{{ route('lay-models.create') }}" class="btn btn-primary-blue">
    <i class="bi bi-plus-lg"></i> Create Lay Model
</a>
@endsection

@section('content')
<!-- Search & Filter Card -->
<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Search & Filter Lay Models</h5>
        <p class="card-custom-subtitle">Filter fabric laying and cutting configurations.</p>

        <form method="GET" action="{{ route('lay-models.index') }}">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">Search</label>
                    <input type="text" name="search" class="form-control form-control-custom" placeholder="Search code, name, garment size, fabric..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-blue">
                    Search & Filter
                </button>
                @if(request('search'))
                    <a href="{{ route('lay-models.index') }}" class="btn btn-outline-custom text-decoration-none">
                        Clear Filters
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="card-custom">
    <div class="card-custom-body pb-0 px-0">
        <div class="d-flex justify-content-between align-items-center px-4 pb-3">
            <h5 class="fw-bold mb-0 text-dark">Lay Model List</h5>
            <span class="text-muted small">{{ $layModels->total() }} model(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>CODE</th>
                        <th>LAY MODEL NAME</th>
                        <th>FABRIC GROUP</th>
                        <th>FABRIC</th>
                        <th>PLIES</th>
                        <th>LAY DIMENSIONS</th>
                        <th>GARMENT SIZE</th>
                        <th>STATUS</th>
                        <th class="text-end">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($layModels as $layModel)
                        <tr>
                            <td class="fw-bold">{{ $layModel->lay_model_code }}</td>
                            <td>{{ $layModel->lay_model_name }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $layModel->fabricGroup ? $layModel->fabricGroup->group_name : '-' }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ $layModel->fabric ? $layModel->fabric->fabric_code : '-' }}</strong>
                                <span class="small text-muted d-block">{{ $layModel->fabric ? $layModel->fabric->fabric_name : '' }}</span>
                            </td>
                            <td><span class="badge bg-info text-white">{{ $layModel->number_of_plies }} plies</span></td>
                            <td>{{ $layModel->lay_length }} &times; {{ $layModel->lay_width }}</td>
                            <td>{{ $layModel->garment_size ?: '-' }}</td>
                            <td>
                                @if($layModel->status === 'Active')
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('lay-models.show', $layModel) }}" class="btn btn-outline-custom btn-sm py-1 px-2" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('lay-models.edit', $layModel) }}" class="btn btn-outline-custom btn-sm py-1 px-2" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('lay-models.destroy', $layModel) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this Lay Model?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                No lay models found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3 d-flex justify-content-end">
            {{ $layModels->links() }}
        </div>
    </div>
</div>
@endsection
