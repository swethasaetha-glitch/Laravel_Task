@extends('layouts.app')

@section('title', 'Cut Room Planner & Settings')
@section('page_header_title', 'Cut Room Planner & Settings')
@section('page_header_subtitle', 'Configure CAD Markers, Cut Plan Types, Piles & Group Allocations (Images 3 & 4)')

@section('content')
<!-- Top Metric Overview Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Total Cut Plans</div>
            <div class="metric-card-value text-primary">{{ $cutPlans->total() }}</div>
            <div class="metric-card-subtext">Active cut room plans</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Active CAD Markers</div>
            <div class="metric-card-value text-info">{{ \App\Models\CutPlan::where('cad_type', 'Marker')->count() }}</div>
            <div class="metric-card-subtext">CAD Marker & Pattern layouts</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Total Piles Planned</div>
            <div class="metric-card-value text-success">{{ \App\Models\CutPlan::sum('no_of_piles') }}</div>
            <div class="metric-card-subtext">Cumulative plies across lays</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Generated Lot Bundles</div>
            <div class="metric-card-value text-warning">{{ \App\Models\LotBundle::count() }}</div>
            <div class="metric-card-subtext">Bundle QR tickets generated</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Modern Cut Plan Creation Form -->
    <div class="col-lg-5">
        <div class="card-custom">
            <div class="card-custom-body">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-scissors fs-5"></i>
                    </div>
                    <div>
                        <h5 class="card-custom-title mb-0">Create New Cut Plan</h5>
                        <p class="card-custom-subtitle mb-0">Configure Cut Settings & Pile Allocations</p>
                    </div>
                </div>

                <form action="{{ route('cut-planning.store') }}" method="POST" class="needs-validation">
                    @csrf

                    <!-- 1. Order & Fabric Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small uppercase">Sales Order & Style</label>
                        <select name="sales_order_id" required class="form-select form-select-custom">
                            <option value="" disabled selected>Select Sales Order...</option>
                            @foreach($salesOrders as $so)
                                <option value="{{ $so->id }}">{{ $so->sales_order_no }} — Style: {{ $so->style_no }} ({{ $so->garment_type }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small uppercase">Fabric Material</label>
                        <select name="fabric_id" required class="form-select form-select-custom">
                            <option value="" disabled selected>Select Fabric...</option>
                            @foreach($fabrics as $fab)
                                <option value="{{ $fab->id }}">{{ $fab->fabric_code }} — {{ $fab->fabric_name }} ({{ $fab->color }}, {{ $fab->gsm }} GSM)</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 2. CAD Type & Unit of Measure -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark small uppercase">CAD Type</label>
                            <select name="cad_type" class="form-select form-select-custom">
                                <option value="Marker">Marker</option>
                                <option value="Pattern">Pattern</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark small uppercase">Unit of Measure</label>
                            <select name="unit_of_measure" class="form-select form-select-custom">
                                <option value="Metres">Metres (Shirts/Denim)</option>
                                <option value="Kg">Kg (Knits)</option>
                            </select>
                        </div>
                    </div>

                    <!-- 3. Cut Plan Type Selector -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small uppercase">Cut Plan Type (Image 4)</label>
                        <select name="cut_plan_type" class="form-select form-select-custom">
                            <option value="selected_ratio">Selected Ratio Cut Plan</option>
                            <option value="step_down">Step Down</option>
                            <option value="mini_marker">Mini Marker</option>
                            <option value="selected_size">Selected Size Cut Plan</option>
                            <option value="piles_multiples">Piles Multiples</option>
                            <option value="partial_cut">Partial Cut Plan</option>
                        </select>
                    </div>

                    <!-- 4. Fabric Group Allocation -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small uppercase">Group Allocation Mode</label>
                        <select name="group_allocation" class="form-select form-select-custom">
                            <option value="automatic">Automatic</option>
                            <option value="factory_cut_plan">Factory Cut Plan</option>
                            <option value="fit_mode">Fit Mode</option>
                            <option value="max_pcs">Max Pcs Cut Plan</option>
                            <option value="piles_adjust">Piles Adjust</option>
                            <option value="equal_size">Equal Size</option>
                            <option value="auto_endbit">Auto Endbit Allocation</option>
                        </select>
                    </div>

                    <!-- 5. Quantities & Piles -->
                    <div class="p-3 bg-light rounded-3 border mb-4">
                        <div class="row g-2">
                            <div class="col-4">
                                <label class="form-label fw-bold text-muted text-uppercase" style="font-size:0.68rem;">No of Piles</label>
                                <input type="number" name="no_of_piles" value="100" min="1" required class="form-control form-control-custom fw-bold text-primary">
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-bold text-muted text-uppercase" style="font-size:0.68rem;">Order Qty</label>
                                <input type="number" name="order_qty" value="1500" min="1" required class="form-control form-control-custom fw-bold">
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-bold text-muted text-uppercase" style="font-size:0.68rem;">Extra Qty</label>
                                <input type="number" name="extra_qty" value="50" min="0" required class="form-control form-control-custom fw-bold text-success">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-blue w-100 py-2.5 justify-content-center">
                        <i class="bi bi-plus-circle-fill"></i> Save Cut Plan & Auto-Generate Bundles
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Enhanced Cut Plan Table -->
    <div class="col-lg-7">
        <div class="card-custom">
            <div class="card-custom-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-custom-title mb-0">Active Cut Plans Catalog</h5>
                        <p class="card-custom-subtitle mb-0">List of planned and active cutting layouts</p>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-bold">
                        {{ $cutPlans->total() }} Records
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Cut Plan No</th>
                                <th>Sales Order</th>
                                <th>Piles</th>
                                <th>Cut Type</th>
                                <th>Allocation Mode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cutPlans as $cp)
                            <tr>
                                <td class="fw-bold text-primary">
                                    {{ $cp->cut_plan_no }}
                                    <div class="text-muted small" style="font-size:0.7rem;">{{ $cp->cad_type }} ({{ $cp->unit_of_measure }})</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $cp->salesOrder?->sales_order_no }}</div>
                                    <div class="text-muted small" style="font-size:0.7rem;">Style: {{ $cp->salesOrder?->style_no }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold">
                                        {{ $cp->no_of_piles }} Piles
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-dark border capitalize" style="font-size:0.7rem;">
                                        {{ str_replace('_', ' ', $cp->cut_plan_type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info border capitalize" style="font-size:0.7rem;">
                                        {{ str_replace('_', ' ', $cp->group_allocation) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-active text-capitalize">
                                        {{ str_replace('_', ' ', $cp->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No cut plans created yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $cutPlans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
