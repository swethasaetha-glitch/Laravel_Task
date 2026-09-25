@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_header_title', 'Production & Department Dashboard')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Manufacturing Execution')

@section('content')
<!-- Metric Summary Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Buyer & Sales Orders</div>
            <div class="metric-card-value text-primary">{{ \App\Models\SalesOrder::count() }}</div>
            <div class="metric-card-subtext">Active sales orders</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Total Fabrics</div>
            <div class="metric-card-value text-info">{{ $totalFabrics }}</div>
            <div class="metric-card-subtext">Fabrics in master catalog</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Fabric Rolls (Store)</div>
            <div class="metric-card-value text-success">{{ \App\Models\FabricRoll::count() }}</div>
            <div class="metric-card-subtext">Received & inspected rolls</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Completed Lay Slips</div>
            <div class="metric-card-value text-warning">{{ \App\Models\LaySlip::count() }}</div>
            <div class="metric-card-subtext">Lay process completed</div>
        </div>
    </div>
</div>

<!-- Department-Wise Production & Machine Throughput Graphs (Chart.js) -->
<div class="row g-3 mb-4">
    <!-- Graph 1: Department-Wise Working Process Bar Chart -->
    <div class="col-lg-7">
        <div class="card-custom h-100">
            <div class="card-custom-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-custom-title mb-0">Department-Wise Working Process Graph</h5>
                        <p class="card-custom-subtitle mb-0">Active Lot Bundles distribution across factory departments</p>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Real-Time Data</span>
                </div>
                <div style="position: relative; height: 300px;">
                    <canvas id="deptWorkProcessChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Graph 2: Department Stage Ratio Doughnut Chart -->
    <div class="col-lg-5">
        <div class="card-custom h-100">
            <div class="card-custom-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-custom-title mb-0">Production Stage Breakdown</h5>
                        <p class="card-custom-subtitle mb-0">Share of WIP bundles by stage</p>
                    </div>
                </div>
                <div style="position: relative; height: 300px;" class="d-flex align-items-center justify-content-center">
                    <canvas id="deptRatioChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Machine In-Scan & Out-Scan Daily Table and Graph -->
<div class="row g-3 mb-4">
    <!-- Machine Scan Comparison Bar Chart -->
    <div class="col-lg-6">
        <div class="card-custom h-100">
            <div class="card-custom-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-custom-title mb-0">Machine In-Scan vs Out-Scan Graph (Today)</h5>
                        <p class="card-custom-subtitle mb-0">Machine throughput comparison</p>
                    </div>
                </div>
                <div style="position: relative; height: 260px;">
                    <canvas id="machineScanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Machine In-Scan & Out-Scan Table -->
    <div class="col-lg-6">
        <div class="card-custom h-100">
            <div class="card-custom-body">
                <h5 class="card-custom-title mb-0">Machine-Wise Scan Logs</h5>
                <p class="card-custom-subtitle mb-3">Daily In-Scan / Out-Scan counts per machine line</p>

                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Machine No</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th class="text-center">In-Scan</th>
                                <th class="text-center">Out-Scan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($machines as $mc)
                            <tr>
                                <td class="fw-bold text-primary">{{ $mc->machine_no }}</td>
                                <td class="fw-semibold text-dark">{{ $mc->machine_name }}</td>
                                <td><span class="badge bg-secondary text-uppercase" style="font-size:0.68rem;">{{ $mc->department }}</span></td>
                                <td class="text-center fw-bold text-success">{{ $mc->in_scans_today }}</td>
                                <td class="text-center fw-bold text-info">{{ $mc->out_scans_today }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quality Control DHU & Laundry Management Side-by-Side -->
<div class="row g-3 mb-4">
    <!-- Quality DHU Rate -->
    <div class="col-lg-6">
        <div class="card-custom h-100">
            <div class="card-custom-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-custom-title mb-0">Quality Control & DHU Rate</h5>
                        <p class="card-custom-subtitle mb-0">Defects Per Hundred Units Audit</p>
                    </div>
                    <span class="badge bg-danger fs-6 px-3 py-2">
                        DHU: {{ $dhuRate }}%
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom align-middle text-sm">
                        <thead>
                            <tr>
                                <th>Bundle No</th>
                                <th>Defect Name</th>
                                <th>Operator</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($qualityAudits as $qa)
                            <tr>
                                <td class="fw-bold text-primary">{{ $qa->lotBundle?->bundle_no }}</td>
                                <td class="text-danger fw-semibold">{{ $qa->garmentDefect?->defect_name ?? 'None' }}</td>
                                <td>{{ $qa->operator?->name ?? 'System' }}</td>
                                <td>
                                    <span class="badge {{ $qa->audit_result === 'pass' ? 'bg-success' : 'bg-danger' }} text-uppercase">
                                        {{ $qa->audit_result }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Laundry & Washing Management -->
    <div class="col-lg-6">
        <div class="card-custom h-100">
            <div class="card-custom-body">
                <h5 class="card-custom-title mb-0">Laundry & Washing Process</h5>
                <p class="card-custom-subtitle mb-3">Garment wash batches and status tracking</p>

                <div class="table-responsive">
                    <table class="table table-custom align-middle text-sm">
                        <thead>
                            <tr>
                                <th>Wash Batch No</th>
                                <th>Wash Type</th>
                                <th>Status</th>
                                <th>Received At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laundryBatches as $lb)
                            <tr>
                                <td class="fw-bold text-primary">{{ $lb->wash_batch_no }}</td>
                                <td class="fw-semibold">{{ $lb->wash_type }}</td>
                                <td>
                                    <span class="badge bg-info text-uppercase">
                                        {{ str_replace('_', ' ', $lb->status) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $lb->created_at?->format('H:i, d M') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Load Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stageLabels = {!! json_encode(array_keys($stageCounts)) !!};
        const stageData = {!! json_encode(array_values($stageCounts)) !!};

        // 1. Department-Wise Bar Chart
        const ctx1 = document.getElementById('deptWorkProcessChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: stageLabels,
                datasets: [{
                    label: 'Active Lot Bundles',
                    data: stageData,
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.75)',
                        'rgba(14, 165, 233, 0.75)',
                        'rgba(245, 158, 11, 0.75)',
                        'rgba(16, 185, 129, 0.75)',
                        'rgba(139, 92, 246, 0.75)',
                        'rgba(236, 72, 153, 0.75)',
                        'rgba(100, 116, 139, 0.75)'
                    ],
                    borderColor: [
                        '#2563eb', '#0ea5e9', '#f59e0b', '#10b981', '#8b5cf6', '#ec4899', '#64748b'
                    ],
                    borderWidth: 1.5,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });

        // 2. Production Stage Ratio Doughnut Chart
        const ctx2 = document.getElementById('deptRatioChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: stageLabels,
                datasets: [{
                    data: stageData,
                    backgroundColor: [
                        '#2563eb', '#0ea5e9', '#f59e0b', '#10b981', '#8b5cf6', '#ec4899', '#64748b'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
                }
            }
        });

        // 3. Machine In-Scan vs Out-Scan Bar Chart
        const machineNames = {!! json_encode($machines->pluck('machine_no')) !!};
        const inScans = {!! json_encode($machines->pluck('in_scans_today')) !!};
        const outScans = {!! json_encode($machines->pluck('out_scans_today')) !!};

        const ctx3 = document.getElementById('machineScanChart').getContext('2d');
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: machineNames,
                datasets: [
                    {
                        label: 'In-Scan Today',
                        data: inScans,
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderRadius: 4
                    },
                    {
                        label: 'Out-Scan Today',
                        data: outScans,
                        backgroundColor: 'rgba(14, 165, 233, 0.8)',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    });
</script>
@endpush
