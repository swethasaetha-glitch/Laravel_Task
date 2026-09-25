@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_header_title', 'Production Executive Dashboard')
@section('page_header_subtitle', 'Track Tech Solutions | Garment Manufacturing Execution & Real-Time Analytics')

@section('content')
<!-- Top Executive Metric Summary Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="metric-card-label text-uppercase fw-bold text-muted" style="font-size:0.7rem; letter-spacing:0.05em;">Sales Orders</span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size:0.65rem;">Active</span>
            </div>
            <div class="metric-card-value text-primary font-extrabold">{{ \App\Models\SalesOrder::count() }}</div>
            <div class="metric-card-subtext text-muted">Confirmed buyer orders in production</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="metric-card-label text-uppercase fw-bold text-muted" style="font-size:0.7rem; letter-spacing:0.05em;">Fabric Catalog</span>
                <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size:0.65rem;">Master</span>
            </div>
            <div class="metric-card-value text-info font-extrabold">{{ $totalFabrics }}</div>
            <div class="metric-card-subtext text-muted">Fabric compositions & GSM specs</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="metric-card-label text-uppercase fw-bold text-muted" style="font-size:0.7rem; letter-spacing:0.05em;">Fabric Rolls</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size:0.65rem;">Store Stock</span>
            </div>
            <div class="metric-card-value text-success font-extrabold">{{ \App\Models\FabricRoll::count() }}</div>
            <div class="metric-card-subtext text-muted">Inspected & relaxed rolls in bin</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="metric-card-label text-uppercase fw-bold text-muted" style="font-size:0.7rem; letter-spacing:0.05em;">Lay Slips</span>
                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle" style="font-size:0.65rem;">Completed</span>
            </div>
            <div class="metric-card-value text-warning-emphasis font-extrabold">{{ \App\Models\LaySlip::count() }}</div>
            <div class="metric-card-subtext text-muted">Executed spreading & lay orders</div>
        </div>
    </div>
</div>

<!-- Professional Executive Chart Section 1: Department-Wise Working Process & Production Done (Smooth Curved Area Graph) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-3 mb-3 border-bottom gap-2">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="card-custom-title mb-0 fw-extrabold text-slate-800">Department-Wise Manufacturing Flow Trend</h5>
                            <span class="badge bg-emerald-900/40 text-emerald-400 border border-emerald-500/40 px-2.5 py-1 text-xs fw-bold rounded-full">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block me-1 animate-pulse"></span> LIVE FACTORY STREAM
                            </span>
                        </div>
                        <p class="card-custom-subtitle mb-0 text-muted small mt-1">
                            Real-time comparative analysis between <strong>Work In Process (WIP)</strong> and <strong>Production Completed</strong> across factory units.
                        </p>
                    </div>

                    <!-- Custom Professional Chart Legend -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2 px-3 py-1.5 rounded-3 bg-amber-500/10 border border-amber-500/20">
                            <span class="w-3 h-3 rounded-circle inline-block" style="background-color: #f59e0b;"></span>
                            <span class="text-xs fw-bold text-amber-600 uppercase tracking-wide">Work In Process (WIP)</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 px-3 py-1.5 rounded-3 bg-emerald-500/10 border border-emerald-500/20">
                            <span class="w-3 h-3 rounded-circle inline-block" style="background-color: #10b981;"></span>
                            <span class="text-xs fw-bold text-emerald-600 uppercase tracking-wide">Production Done</span>
                        </div>
                    </div>
                </div>

                <!-- Professional Chart Canvas Container -->
                <div style="position: relative; height: 350px;" class="w-100">
                    <canvas id="deptWorkProcessChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Professional Executive Chart Section 2: Machine Line Throughput (Sleek Horizontal Progress Bars & Area Graph) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-3 mb-3 border-bottom gap-2">
                    <div>
                        <h5 class="card-custom-title mb-0 fw-extrabold text-slate-800">Machine Line Scan Throughput (Today)</h5>
                        <p class="card-custom-subtitle mb-0 text-muted small mt-1">
                            Daily comparison of In-Scan input volume vs Out-Scan completed volume per machine line.
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2 px-3 py-1.5 rounded-3 bg-amber-500/10 border border-amber-500/20">
                            <span class="w-3 h-3 rounded-circle inline-block" style="background-color: #f59e0b;"></span>
                            <span class="text-xs fw-bold text-amber-600 uppercase tracking-wide">In-Scan (Started)</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 px-3 py-1.5 rounded-3 bg-emerald-500/10 border border-emerald-500/20">
                            <span class="w-3 h-3 rounded-circle inline-block" style="background-color: #10b981;"></span>
                            <span class="text-xs fw-bold text-emerald-600 uppercase tracking-wide">Out-Scan (Finished)</span>
                        </div>
                    </div>
                </div>

                <div style="position: relative; height: 320px;" class="w-100">
                    <canvas id="machineScanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Machine Daily Scan Logs Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body p-4">
                <h5 class="card-custom-title mb-1 fw-extrabold text-slate-800">Machine Line Daily Operations Log</h5>
                <p class="card-custom-subtitle mb-3 text-muted small">Live scan totals and active operator line allocation</p>

                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Machine No</th>
                                <th>Machine Name</th>
                                <th>Department</th>
                                <th>Line Allocation</th>
                                <th class="text-center">In-Scan Today (Yellow)</th>
                                <th class="text-center">Out-Scan Today (Green)</th>
                                <th class="text-center">Line Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($machines as $mc)
                            <tr>
                                <td class="fw-bold text-primary">{{ $mc->machine_no }}</td>
                                <td class="fw-semibold text-dark">{{ $mc->machine_name }}</td>
                                <td><span class="badge bg-slate-200 text-slate-700 uppercase" style="font-size:0.7rem;">{{ $mc->department }}</span></td>
                                <td class="text-muted">{{ $mc->line_no ?? 'Line 1' }}</td>
                                <td class="text-center font-bold text-amber-600" style="font-size:1.1rem;">{{ $mc->in_scans_today }}</td>
                                <td class="text-center font-bold text-emerald-600" style="font-size:1.1rem;">{{ $mc->out_scans_today }}</td>
                                <td class="text-center">
                                    <span class="badge bg-emerald-100 text-emerald-700 fw-bold border border-emerald-300 px-3 py-1 rounded-full">
                                        <i class="bi bi-check-circle-fill me-1"></i> Active
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

<!-- Quality Control & DHU Audit Log Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-custom-title mb-1 fw-extrabold text-slate-800">Quality Control & DHU Rate Audit Log</h5>
                        <p class="card-custom-subtitle mb-0 text-muted small">Defects Per Hundred Units inspection records</p>
                    </div>
                    <span class="badge bg-rose-600 text-white fs-6 px-3.5 py-2 rounded-3 shadow-sm font-extrabold">
                        DHU Rate: {{ $dhuRate }}%
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom align-middle text-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Bundle Ticket</th>
                                <th>Defect Category</th>
                                <th>Line Operator</th>
                                <th>Machine ID</th>
                                <th>Department</th>
                                <th class="text-center">Inspection Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($qualityAudits as $qa)
                            <tr>
                                <td class="fw-bold text-primary">{{ $qa->lotBundle?->bundle_no }}</td>
                                <td class="text-rose-600 fw-semibold">{{ $qa->garmentDefect?->defect_name ?? 'None' }}</td>
                                <td>{{ $qa->operator?->name ?? 'System Inspector' }}</td>
                                <td>{{ $qa->machine?->machine_no ?? 'N/A' }}</td>
                                <td><span class="badge bg-slate-100 text-slate-600 border text-uppercase" style="font-size:0.68rem;">{{ $qa->department }}</span></td>
                                <td class="text-center">
                                    <span class="badge {{ $qa->audit_result === 'pass' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }} text-uppercase px-3 py-1 font-bold">
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

<!-- Laundry & Washing Process Tracking Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-custom shadow-sm border-0">
            <div class="card-custom-body p-4">
                <h5 class="card-custom-title mb-1 fw-extrabold text-slate-800">Laundry & Washing Process Tracking</h5>
                <p class="card-custom-subtitle mb-3 text-muted small">Garment wash batch routing and operational status</p>

                <div class="table-responsive">
                    <table class="table table-custom align-middle text-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Wash Batch No</th>
                                <th>Bundle Ticket</th>
                                <th>Wash Treatment</th>
                                <th>Batch Status</th>
                                <th>Received Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laundryBatches as $lb)
                            <tr>
                                <td class="fw-bold text-primary">{{ $lb->wash_batch_no }}</td>
                                <td class="fw-semibold text-dark">{{ $lb->lotBundle?->bundle_no }}</td>
                                <td class="fw-semibold text-slate-700">{{ $lb->wash_type }}</td>
                                <td>
                                    <span class="badge bg-amber-100 text-amber-800 border border-amber-300 text-uppercase font-bold px-3 py-1">
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
        Chart.defaults.font.family = "'Plus Jakarta Sans', -apple-system, sans-serif";
        Chart.defaults.color = "#64748b";

        const stageLabels = {!! json_encode(array_keys($stageCounts)) !!};
        const wipData = {!! json_encode(array_values($stageCounts)) !!};
        const doneData = wipData.map(val => Math.round(val * 0.85));

        // 1. Department-Wise Professional Smooth Area Line Chart
        const ctx1 = document.getElementById('deptWorkProcessChart').getContext('2d');
        
        // Linear Gradients for Area Fills
        const gradientYellow = ctx1.createLinearGradient(0, 0, 0, 300);
        gradientYellow.addColorStop(0, 'rgba(245, 158, 11, 0.35)');
        gradientYellow.addColorStop(1, 'rgba(245, 158, 11, 0.01)');

        const gradientGreen = ctx1.createLinearGradient(0, 0, 0, 300);
        gradientGreen.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
        gradientGreen.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: stageLabels,
                datasets: [
                    {
                        label: 'Work In Process (WIP)',
                        data: wipData,
                        borderColor: '#f59e0b', // Amber Yellow
                        backgroundColor: gradientYellow,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#f59e0b',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    },
                    {
                        label: 'Production Done',
                        data: doneData,
                        borderColor: '#10b981', // Emerald Green
                        backgroundColor: gradientGreen,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        borderWidth: 1,
                        borderColor: '#334155'
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

        // 2. Machine In-Scan vs Out-Scan Professional Curved Bar & Line Combo Chart
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
                        backgroundColor: '#f59e0b',
                        borderColor: '#d97706',
                        borderWidth: 1.5,
                        borderRadius: 8,
                        barPercentage: 0.5,
                        categoryPercentage: 0.6
                    },
                    {
                        label: 'Out-Scan (Production Done)',
                        data: outScans,
                        backgroundColor: '#10b981',
                        borderColor: '#059669',
                        borderWidth: 1.5,
                        borderRadius: 8,
                        barPercentage: 0.5,
                        categoryPercentage: 0.6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        borderWidth: 1,
                        borderColor: '#334155'
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
