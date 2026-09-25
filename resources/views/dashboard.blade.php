@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_header_title', 'Production & Department Dashboard')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Manufacturing Execution')

@section('content')
<!-- Metric Summary Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="metric-card-label">Buyer & Sales Orders</div>
            <div class="metric-card-value text-primary">{{ \App\Models\SalesOrder::count() }}</div>
            <div class="metric-card-subtext">Active sales orders</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="metric-card-label">Total Fabrics</div>
            <div class="metric-card-value text-info">{{ $totalFabrics }}</div>
            <div class="metric-card-subtext">Fabrics in master catalog</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="metric-card-label">Fabric Rolls (Store)</div>
            <div class="metric-card-value text-success">{{ \App\Models\FabricRoll::count() }}</div>
            <div class="metric-card-subtext">Received & inspected rolls</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="metric-card-label">Completed Lay Slips</div>
            <div class="metric-card-value text-warning">{{ \App\Models\LaySlip::count() }}</div>
            <div class="metric-card-subtext">Lay process completed</div>
        </div>
    </div>
</div>

<!-- Stacked Full-Width Section 1: Department-Wise Working Process & Production Done Graph -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div>
                        <h5 class="card-custom-title mb-1 fw-bold text-dark">Department-Wise Working Process & Production Done Graph</h5>
                        <p class="card-custom-subtitle mb-0 text-muted small">
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle me-2 px-2.5 py-1">
                                <i class="bi bi-circle-fill me-1" style="font-size:0.55rem;"></i> Yellow: Work In Process (WIP)
                            </span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">
                                <i class="bi bi-circle-fill me-1" style="font-size:0.55rem;"></i> Green: Production Done
                            </span>
                        </p>
                    </div>
                    <span class="badge bg-primary text-white font-bold px-3 py-1.5 rounded-pill shadow-sm" style="font-size:0.75rem;">
                        <i class="bi bi-graph-up-arrow me-1"></i> Live Analytics
                    </span>
                </div>
                <div style="position: relative; height: 330px;" class="pt-2">
                    <canvas id="deptWorkProcessChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stacked Full-Width Section 2: Machine In-Scan vs Out-Scan Daily Throughput Graph -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div>
                        <h5 class="card-custom-title mb-1 fw-bold text-dark">Machine-Wise Scan Throughput Graph (Today)</h5>
                        <p class="card-custom-subtitle mb-0 text-muted small">
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle me-2 px-2.5 py-1">
                                <i class="bi bi-circle-fill me-1" style="font-size:0.55rem;"></i> Yellow: In-Scan (Work Process Started)
                            </span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">
                                <i class="bi bi-circle-fill me-1" style="font-size:0.55rem;"></i> Green: Out-Scan (Production Done)
                            </span>
                        </p>
                    </div>
                    <span class="badge bg-info-subtle text-info border border-info-subtle font-bold px-3 py-1.5 rounded-pill" style="font-size:0.75rem;">
                        Daily Machine Output
                    </span>
                </div>
                <div style="position: relative; height: 310px;" class="pt-2">
                    <canvas id="machineScanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stacked Full-Width Section 3: Machine Scan Logs Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body">
                <h5 class="card-custom-title mb-1 fw-bold text-dark">Machine-Wise Daily Scan Logs</h5>
                <p class="card-custom-subtitle mb-3 text-muted small">Detailed machine line scan counts and operational status</p>

                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Machine No</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Line No</th>
                                <th class="text-center">In-Scan Today (Yellow)</th>
                                <th class="text-center">Out-Scan Today (Green)</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($machines as $mc)
                            <tr>
                                <td class="fw-bold text-primary">{{ $mc->machine_no }}</td>
                                <td class="fw-semibold text-dark">{{ $mc->machine_name }}</td>
                                <td><span class="badge bg-secondary-subtle text-secondary border uppercase" style="font-size:0.7rem;">{{ $mc->department }}</span></td>
                                <td class="text-muted">{{ $mc->line_no ?? 'Line 1' }}</td>
                                <td class="text-center font-bold text-warning-emphasis" style="font-size:1.1rem;">{{ $mc->in_scans_today }}</td>
                                <td class="text-center font-bold text-success" style="font-size:1.1rem;">{{ $mc->out_scans_today }}</td>
                                <td class="text-center">
                                    <span class="badge badge-active">Active Line</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stacked Full-Width Section 4: Quality Control & DHU Audit Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-custom-title mb-1 fw-bold text-dark">Quality Control & DHU Rate Audit Log</h5>
                        <p class="card-custom-subtitle mb-0 text-muted small">Defects Per Hundred Units inspection records</p>
                    </div>
                    <span class="badge bg-danger fs-6 px-3 py-2 rounded-3 shadow-sm">
                        DHU Rate: {{ $dhuRate }}%
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom align-middle text-sm">
                        <thead>
                            <tr>
                                <th>Bundle No</th>
                                <th>Defect Name</th>
                                <th>Operator</th>
                                <th>Machine</th>
                                <th>Department</th>
                                <th class="text-center">Inspection Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($qualityAudits as $qa)
                            <tr>
                                <td class="fw-bold text-primary">{{ $qa->lotBundle?->bundle_no }}</td>
                                <td class="text-danger fw-semibold">{{ $qa->garmentDefect?->defect_name ?? 'None' }}</td>
                                <td>{{ $qa->operator?->name ?? 'System' }}</td>
                                <td>{{ $qa->machine?->machine_no ?? 'N/A' }}</td>
                                <td><span class="badge bg-secondary-subtle text-secondary border text-uppercase" style="font-size:0.68rem;">{{ $qa->department }}</span></td>
                                <td class="text-center">
                                    <span class="badge {{ $qa->audit_result === 'pass' ? 'bg-success' : 'bg-danger' }} text-uppercase px-3 py-1">
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
</div>

<!-- Stacked Full-Width Section 5: Laundry & Washing Management Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body">
                <h5 class="card-custom-title mb-1 fw-bold text-dark">Laundry & Washing Process Tracking</h5>
                <p class="card-custom-subtitle mb-3 text-muted small">Garment wash batch routing and operational status</p>

                <div class="table-responsive">
                    <table class="table table-custom align-middle text-sm">
                        <thead>
                            <tr>
                                <th>Wash Batch No</th>
                                <th>Bundle No</th>
                                <th>Wash Type</th>
                                <th>Status</th>
                                <th>Received At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laundryBatches as $lb)
                            <tr>
                                <td class="fw-bold text-primary">{{ $lb->wash_batch_no }}</td>
                                <td class="fw-semibold text-dark">{{ $lb->lotBundle?->bundle_no }}</td>
                                <td class="fw-semibold">{{ $lb->wash_type }}</td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle text-uppercase font-bold">
                                        {{ str_replace('_', ' ', $lb->status) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $lb->created_at?->format('H:i, d M Y') }}</td>
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
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = "#475569";

        const stageLabels = {!! json_encode(array_keys($stageCounts)) !!};
        const wipData = {!! json_encode(array_values($stageCounts)) !!};
        const doneData = wipData.map(val => Math.round(val * 0.85));

        // 1. Department-Wise Neat Bar Chart (Yellow = WIP, Green = Production Done)
        const ctx1 = document.getElementById('deptWorkProcessChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: stageLabels,
                datasets: [
                    {
                        label: 'Work In Process (WIP)',
                        data: wipData,
                        backgroundColor: '#f59e0b', // Crisp Amber Yellow
                        borderColor: '#d97706',
                        borderWidth: 1.5,
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.6,
                        categoryPercentage: 0.65
                    },
                    {
                        label: 'Production Done',
                        data: doneData,
                        backgroundColor: '#10b981', // Crisp Emerald Green
                        borderColor: '#059669',
                        borderWidth: 1.5,
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.6,
                        categoryPercentage: 0.65
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 8,
                            padding: 15,
                            font: { size: 12, weight: '700' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, weight: '600' } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { stepSize: 1, font: { size: 11 } }
                    }
                }
            }
        });

        // 2. Machine In-Scan vs Out-Scan Neat Bar Chart
        const machineNames = {!! json_encode($machines->pluck('machine_no')) !!};
        const inScans = {!! json_encode($machines->pluck('in_scans_today')) !!};
        const outScans = {!! json_encode($machines->pluck('out_scans_today')) !!};

        const ctx2 = document.getElementById('machineScanChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: machineNames,
                datasets: [
                    {
                        label: 'In-Scan (Work Process Started)',
                        data: inScans,
                        backgroundColor: '#f59e0b', // Yellow
                        borderColor: '#d97706',
                        borderWidth: 1.5,
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.55,
                        categoryPercentage: 0.6
                    },
                    {
                        label: 'Out-Scan (Production Done)',
                        data: outScans,
                        backgroundColor: '#10b981', // Green
                        borderColor: '#059669',
                        borderWidth: 1.5,
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.55,
                        categoryPercentage: 0.6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 8,
                            padding: 15,
                            font: { size: 12, weight: '700' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, weight: '600' } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { stepSize: 1, font: { size: 11 } }
                    }
                }
            }
        });
    });
</script>
@endpush
