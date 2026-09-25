@extends('layouts.app')

@section('title', 'Fabrics')
@section('page_header_title', 'Fabric Master')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')

@section('top_header_action')
<a href="{{ route('fabrics.create') }}" class="btn btn-primary-blue">
    <i class="bi bi-plus-lg"></i> Add New Fabric
</a>
@endsection

@section('content')
<!-- Search & Filter Card -->
<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Search & Filter Fabrics</h5>
        <p class="card-custom-subtitle">Search and filter fabric catalog based on specifications.</p>

        <form method="GET" action="{{ route('fabrics.index') }}">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">Search</label>
                    <input type="text" name="search" class="form-control form-control-custom" placeholder="Search by fabric code, name, type, composition..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-blue">
                    Search & Filter
                </button>
                @if(request('search'))
                    <a href="{{ route('fabrics.index') }}" class="btn btn-outline-custom text-decoration-none">
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
            <h5 class="fw-bold mb-0 text-dark">Fabric Catalog List</h5>
            <span class="text-muted small">{{ $fabrics->total() }} fabric(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>CODE</th>
                        <th>NAME</th>
                        <th>TYPE</th>
                        <th>COMPOSITION</th>
                        <th>GSM</th>
                        <th>WIDTH</th>
                        <th>STATUS</th>
                        <th class="text-end">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fabrics as $fabric)
                        <tr>
                            <td class="fw-bold">{{ $fabric->fabric_code }}</td>
                            <td>{{ $fabric->fabric_name }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $fabric->fabric_type }}</span></td>
                            <td>{{ $fabric->composition ?: '-' }}</td>
                            <td>{{ $fabric->gsm ?: '-' }}</td>
                            <td>{{ $fabric->width ? $fabric->width . ' ' . ($fabric->unit ?: '') : '-' }}</td>
                            <td>
                                @if($fabric->status === 'Active')
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('fabrics.show', $fabric) }}" class="btn btn-outline-custom btn-sm py-1 px-2" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('fabrics.edit', $fabric) }}" class="btn btn-outline-custom btn-sm py-1 px-2" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('fabrics.destroy', $fabric) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this fabric?');">
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
                            <td colspan="8" class="text-center py-4 text-muted">
                                No fabrics found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3 d-flex justify-content-end">
            {{ $fabrics->links() }}
        </div>
    </div>
</div>
@endsection
