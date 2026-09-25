@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_header_title', 'Production Dashboard')
@section('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')

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
                        <a href="{{ route('lay-models.index') }}" class="btn btn-sm btn-outline-custom text-start">&bull; Lay Models</a>
                        <a href="{{ route('lay-slips.index') }}" class="btn btn-sm btn-primary-blue text-start">&bull; Lay Slips (Lay Completed)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
