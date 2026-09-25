@extends('layouts.app')

@section('title', 'Fabric Groups')
@section('page_header_title', 'Fabric Groups')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')

@section('top_header_action')
<a href="{{ route('fabric-groups.create') }}" class="btn btn-primary-blue">
    <i class="bi bi-plus-lg"></i> Create Fabric Group
</a>
@endsection

@section('content')
<!-- Search & Filter Card -->
<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Search & Filter Fabric Groups</h5>
        <p class="card-custom-subtitle">Filter fabric category groupings.</p>

        <form method="GET" action="{{ route('fabric-groups.index') }}">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">Search</label>
                    <input type="text" name="search" class="form-control form-control-custom" placeholder="Search group code, name, description..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-blue">
                    Search & Filter
                </button>
                @if(request('search'))
                    <a href="{{ route('fabric-groups.index') }}" class="btn btn-outline-custom text-decoration-none">
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
            <h5 class="fw-bold mb-0 text-dark">Fabric Group List</h5>
            <span class="text-muted small">{{ $fabricGroups->total() }} group(s)</span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>GROUP CODE</th>
                        <th>GROUP NAME</th>
                        <th>DESCRIPTION</th>
                        <th>ASSIGNED FABRICS</th>
                        <th>STATUS</th>
                        <th class="text-end">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fabricGroups as $group)
                        <tr>
                            <td class="fw-bold">{{ $group->group_code }}</td>
                            <td>{{ $group->group_name }}</td>
                            <td>{{ Str::limit($group->description, 50) ?: '-' }}</td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $group->fabrics_count }} fabrics</span>
                            </td>
                            <td>
                                @if($group->status === 'Active')
                                    <span class="badge-active">Active</span>
                                @else
                                    <span class="badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('fabric-groups.show', $group) }}" class="btn btn-outline-custom btn-sm py-1 px-2" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('fabric-groups.edit', $group) }}" class="btn btn-outline-custom btn-sm py-1 px-2" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('fabric-groups.destroy', $group) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this group?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">
                                No fabric groups found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3 d-flex justify-content-end">
            {{ $fabricGroups->links() }}
        </div>
    </div>
</div>
@endsection
