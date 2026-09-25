@extends('layouts.app')

@section('title', 'App Test - Track Tech Solution')
@section('page_header_title', 'APP TEST')
@section('page_header_subtitle', 'Track Tech Solution | Module Catalog & App Version Suite')

@section('content')
<style>
    .sky-header-banner {
        background: linear-gradient(90deg, #0284c7 0%, #0369a1 100%);
        padding: 1rem 1.5rem;
        border-radius: 12px 12px 0 0;
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .app-tester-badge {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 6px 14px;
        border-radius: 20px;
    }
    .table-app-test {
        width: 100%;
        border-collapse: collapse;
    }
    .table-app-test th {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #1e293b;
        background-color: #ffffff;
        padding: 12px 16px;
        border-bottom: 2px solid #e2e8f0;
        border-top: 1px solid #e2e8f0;
    }
    .table-app-test td {
        padding: 12px 16px;
        font-size: 0.88rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        text-align: center;
    }
    .table-app-test td:nth-child(2) {
        font-weight: 600;
        color: #0f172a;
    }
    .table-app-test td:nth-child(3) {
        font-family: monospace;
        color: #64748b;
    }
</style>

<!-- Top Sky Blue Header Card (Matching Screenshot) -->
<div class="card-custom border-0 overflow-hidden mb-4">
    <div class="sky-header-banner">
        <div class="d-flex align-items-center gap-2">
            <div class="bg-white rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-gear-fill text-primary"></i>
            </div>
            <span class="fw-bold fs-5">Track Tech Solution</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="app-tester-badge">
                <i class="bi bi-person-fill me-1"></i> APP Tester <i class="bi bi-chevron-down ms-1"></i>
            </div>
            <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold" style="font-size: 0.75rem;">ONLINE</span>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="card-custom">
    <div class="card-custom-body p-4">
        <h5 class="fw-bold text-dark mb-4 text-uppercase" style="letter-spacing: 0.05em; font-size: 1rem;">APP TEST</h5>

        <!-- Controls Row -->
        <form method="GET" action="{{ route('app-test.index') }}" class="row align-items-center justify-content-between mb-4 g-2">
            <div class="col-auto d-flex align-items-center gap-2">
                <span class="text-muted small">Show</span>
                <select name="per_page" class="form-select form-select-sm form-select-custom" style="width: 80px;" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
                <span class="text-muted small">entries</span>
            </div>

            <div class="col-auto d-flex align-items-center gap-2">
                <span class="text-muted small fw-semibold">Search:</span>
                <input type="text" name="search" class="form-control form-control-sm form-control-custom" style="width: 220px;" placeholder="Filter apps..." value="{{ request('search') }}" onchange="this.form.submit()">
            </div>
        </form>

        <!-- App Test Table -->
        <div class="table-responsive">
            <table class="table-app-test">
                <thead>
                    <tr>
                        <th style="width: 80px;">SNO &uarr;</th>
                        <th class="text-start">APP</th>
                        <th>PACKAGE</th>
                        <th>LIVE VERSION</th>
                        <th>TEST VERSION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($apps as $app)
                        <tr>
                            <td>{{ $app->sno }}</td>
                            <td class="text-start">
                                @if($app->route_name && Route::has($app->route_name))
                                    <a href="{{ route($app->route_name) }}" class="text-decoration-none text-dark fw-bold hover-primary">
                                        {{ $app->app_name }} <i class="bi bi-arrow-up-right-square text-primary ms-1 small"></i>
                                    </a>
                                @else
                                    {{ $app->app_name }}
                                @endif
                            </td>
                            <td>{{ $app->package_name }}</td>
                            <td><span class="badge bg-light text-dark border px-2 py-1">{{ $app->live_version }}</span></td>
                            <td><span class="badge bg-light text-dark border px-2 py-1">{{ $app->test_version }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Pagination & Count -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top gap-3">
            <div class="text-muted small">
                Showing {{ $apps->firstItem() ?: 0 }} to {{ $apps->lastItem() ?: 0 }} of {{ $apps->total() }} entries
            </div>
            <div>
                {{ $apps->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
