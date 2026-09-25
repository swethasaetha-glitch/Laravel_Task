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
            <div class="metric-card-value">{{ \App\Models\SalesOrder::count() }}</div>
            <div class="metric-card-subtext">Active sales orders</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Total Fabrics</div>
            <div class="metric-card-value">{{ $totalFabrics }}</div>
            <div class="metric-card-subtext">Fabrics in master catalog</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Fabric Rolls (Store)</div>
            <div class="metric-card-value">{{ \App\Models\FabricRoll::count() }}</div>
            <div class="metric-card-subtext">Received & inspected rolls</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Completed Lay Slips</div>
            <div class="metric-card-value">{{ \App\Models\LaySlip::count() }}</div>
            <div class="metric-card-subtext">Lay process completed</div>
        </div>
    </div>
</div>

<!-- Integrated Live Production Working Process Stages -->
<div class="card-custom mb-4">
    <div class="card-custom-body">
        <div class="d-flex justify-content-between items-center mb-3">
            <div>
                <h5 class="card-custom-title">Live Working Process (Stage Wise)</h5>
                <p class="card-custom-subtitle mb-0">Active garment lot bundles across manufacturing departments</p>
            </div>
            <span class="badge bg-success px-3 py-2 text-uppercase font-bold">
                <i class="bi bi-circle-fill text-white me-1" style="font-size:0.6rem;"></i> Live System Tracking
            </span>
        </div>

        <div class="row g-3 text-center">
            @foreach($stageCounts as $stage => $count)
            <div class="col-6 col-md-3 col-lg">
                <div class="p-3 bg-slate-900 text-white rounded-3 border border-slate-700 h-100 shadow-sm">
                    <p class="text-uppercase text-muted fw-bold mb-1" style="font-size:0.68rem; letter-spacing:0.05em;">{{ $stage }}</p>
                    <h3 class="fw-extrabold text-primary mb-1">{{ $count }}</h3>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size:0.65rem;">Active Bundles</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Machine In-Scan & Out-Scan Daily Table -->
<div class="card-custom mb-4">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Department-Wise & Machine-Wise Scan Tracking (Today)</h5>
        <p class="card-custom-subtitle">Real-time daily In-Scan vs Out-Scan throughput per sewing/cutting machine line</p>

        <div class="table-responsive">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th>Machine No</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Line No</th>
                        <th class="text-center">In-Scan Today</th>
                        <th class="text-center">Out-Scan Today</th>
                        <th class="text-center">Efficiency Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($machines as $mc)
                    <tr>
                        <td class="fw-bold text-primary">{{ $mc->machine_no }}</td>
                        <td class="fw-semibold text-dark">{{ $mc->machine_name }}</td>
                        <td><span class="badge bg-secondary text-uppercase" style="font-size:0.68rem;">{{ $mc->department }}</span></td>
                        <td class="text-muted">{{ $mc->line_no ?? 'Line 1' }}</td>
                        <td class="text-center fw-bold text-success">{{ $mc->in_scans_today }}</td>
                        <td class="text-center fw-bold text-info">{{ $mc->out_scans_today }}</td>
                        <td class="text-center">
                            <span class="badge badge-active">94.5%</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quality Dashboard & Laundry Management Side-by-Side -->
<div class="row g-3 mb-4">
    <!-- Quality DHU Rate -->
    <div class="col-lg-6">
        <div class="card-custom h-100">
            <div class="card-custom-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-custom-title">Quality Control & DHU Rate</h5>
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
                <h5 class="card-custom-title">Laundry & Washing Process</h5>
                <p class="card-custom-subtitle">Garment wash batches and status tracking</p>

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

<!-- Garment Manufacturing Process Pipeline -->
<div class="card-custom mb-4">
    <div class="card-custom-body">
        <h5 class="card-custom-title">Garment Manufacturing Process Sequence</h5>
        <p class="card-custom-subtitle">Connected enterprise workflow: Buyer Order &rarr; ERP Entry &rarr; Fabric ERP & Store &rarr; Cut Room & Lay Process Completed.</p>

        <div class="row g-3 py-2">
            <!-- Stage 1 -->
            <div class="col-md-3">
                <div class="p-3 bg-light rounded-3 h-100 border">
                    <span class="badge bg-primary text-uppercase mb-2">1. Order & Planning</span>
                    <h6 class="fw-bold mt-1">Buyer Order & ERP Entry</h6>
                    <p class="small text-muted mb-2">Buyer PO &rarr; Sales Order &rarr; Production Target Scheduling</p>
                    <div class="d-flex flex-column gap-1">
                        <a href="{{ route('buyer-orders.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Buyer Orders (PO)</a>
                        <a href="{{ route('sales-orders.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Sales Orders (ERP)</a>
                        <a href="{{ route('production-plans.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Production Planning</a>
                    </div>
                </div>
            </div>

            <!-- Stage 2 -->
            <div class="col-md-3">
                <div class="p-3 bg-light rounded-3 h-100 border">
                    <span class="badge bg-info text-white text-uppercase mb-2">2. Procurement & Receiving</span>
                    <h6 class="fw-bold mt-1">Fabric PO & GRN Store</h6>
                    <p class="small text-muted mb-2">Fabric Requirement &rarr; Procurement PO &rarr; Goods Receiving Note (GRN)</p>
                    <div class="d-flex flex-column gap-1">
                        <a href="{{ route('fabrics.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Fabric Master</a>
                        <a href="{{ route('fabric-pos.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Fabric Procurement</a>
                        <a href="{{ route('fabric-grns.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Receiving & GRN</a>
                    </div>
                </div>
            </div>

            <!-- Stage 3 -->
            <div class="col-md-3">
                <div class="p-3 bg-light rounded-3 h-100 border">
                    <span class="badge bg-warning text-dark text-uppercase mb-2">3. Quality & Relaxation</span>
                    <h6 class="fw-bold mt-1">4-Point Inspection & Relaxation</h6>
                    <p class="small text-muted mb-2">Defect Inspection &rarr; Roll Grading &rarr; Shade Grouping &rarr; 24h Relaxation</p>
                    <div class="d-flex flex-column gap-1">
                        <a href="{{ route('fabric-inspections.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; 4-Point Inspection</a>
                        <a href="{{ route('fabric-relaxations.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Fabric Relaxation</a>
                        <a href="{{ route('fabric-groups.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Fabric Groups (Lot)</a>
                    </div>
                </div>
            </div>

            <!-- Stage 4 -->
            <div class="col-md-3">
                <div class="p-3 bg-light rounded-3 h-100 border border-success">
                    <span class="badge bg-success text-uppercase mb-2">4. Cut Room & Lay</span>
                    <h6 class="fw-bold mt-1 text-success">Lay Planning & Completion</h6>
                    <p class="small text-muted mb-2">Marker Specs &rarr; Table Allocation &rarr; Spreading &rarr; Lay Slip Executed</p>
                    <div class="d-flex flex-column gap-1">
                        <a href="{{ route('cut-planning.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Cut Room Planner</a>
                        <a href="{{ route('lay-models.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Lay Models</a>
                        <a href="{{ route('lay-slips.index') }}" class="btn btn-sm btn-primary-blue text-start">&bull; Lay Slips (Lay Completed)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
