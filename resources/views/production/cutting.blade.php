@extends('layouts.app')

@section('title', 'Cutting Management & Operations')
@section('page_header_title', 'Cutting Operations & Floor Execution')
@section('page_header_subtitle', 'Track Tech Solutions | Fabric Spreading, Lay Cutting & Bundle QR Tickets')

@section('top_header_action')
<button type="button" class="btn btn-primary-blue shadow-lg" data-bs-toggle="modal" data-bs-target="#startCutModal">
    <i class="bi bi-scissors fs-5"></i> Start New Cut Order
</button>
@endsection

@section('content')
<!-- Metric Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Active Lay Orders</div>
            <div class="metric-card-value text-primary">{{ $cutPlans->count() }}</div>
            <div class="metric-card-subtext">Orders currently on cutting tables</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Total Plies Cut</div>
            <div class="metric-card-value text-success">{{ $cutPlans->sum('no_of_piles') }}</div>
            <div class="metric-card-subtext">Plies processed across lays</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Cutting Machines Online</div>
            <div class="metric-card-value text-info">{{ $cuttingMachines->count() }}</div>
            <div class="metric-card-subtext">Auto Cutters & Knife machines</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-card-label">Bundle QR Tickets</div>
            <div class="metric-card-value text-warning">{{ $lotBundles->count() }}</div>
            <div class="metric-card-subtext">Numbering & bundling complete</div>
        </div>
    </div>
</div>

<!-- Interactive Modal: Start New Cut Order (Resolves "start cut kudutha option varula check") -->
<div class="modal fade" id="startCutModal" tabindex="-1" aria-labelledby="startCutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-2xl border-0">
            <div class="modal-header bg-gradient-to-r from-sky-600 to-blue-700 text-white rounded-t-4 py-3">
                <h5 class="modal-title font-bold d-flex align-items-center gap-2" id="startCutModalLabel">
                    <i class="bi bi-scissors fs-4"></i> Start New Cut Order & Spreading Lay
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('production.cutting.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 space-y-4">
                    <div class="alert alert-info py-2 px-3 mb-3 text-xs d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill fs-6"></i>
                        <span>Execution steps from handwritten notes: <strong>1. Select Cut → 2. Specify Plies → 3. Fabric Enter → 4. OK Lay → 5. Execute Cut & QR Bundle</strong></span>
                    </div>

                    <div class="row g-3">
                        <!-- Sales Order & Style -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Sales Order & Style</label>
                            <select name="sales_order_id" required class="form-select form-select-custom">
                                <option value="" disabled selected>Select Sales Order...</option>
                                @foreach($salesOrders as $so)
                                    <option value="{{ $so->id }}">{{ $so->sales_order_no }} — Style: {{ $so->style_no }} ({{ $so->garment_type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fabric Material -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Fabric Material</label>
                            <select name="fabric_id" required class="form-select form-select-custom">
                                <option value="" disabled selected>Select Fabric Roll...</option>
                                @foreach($fabrics as $fab)
                                    <option value="{{ $fab->id }}">{{ $fab->fabric_code }} — {{ $fab->fabric_name }} ({{ $fab->color }}, {{ $fab->gsm }} GSM)</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cutting Machine / Method (Image 1: Straight Knife, Band, Gerber, Manual) -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Cutting Method & Machine (Image 1)</label>
                            <select name="cutting_method" required class="form-select form-select-custom">
                                <option value="Gerber Auto Cutter">Gerber Auto Cutter</option>
                                <option value="Straight Knife">Straight Knife</option>
                                <option value="Band Knife">Band Knife</option>
                                <option value="Manual Cutting">Manual Cutting</option>
                            </select>
                        </div>

                        <!-- Table Assignment (Image 5) -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Lay Table Assignment (Image 5)</label>
                            <select name="table_no" required class="form-select form-select-custom">
                                <option value="Table 01 (Auto Spreader)">Table 01 (Auto Spreader)</option>
                                <option value="Table 02 (Manual Lay)">Table 02 (Manual Lay)</option>
                                <option value="Table 03 (High Density)">Table 03 (High Density)</option>
                                <option value="Table 04 (Gerber System)">Table 04 (Gerber System)</option>
                            </select>
                        </div>

                        <!-- Layman Operator -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Layman Cutter Operator</label>
                            <select name="operator_id" class="form-select form-select-custom">
                                <option value="">Auto Assign Lead Cutter</option>
                                @foreach($operators as $op)
                                    <option value="{{ $op->id }}">{{ $op->operator_code }} — {{ $op->name }} ({{ $op->department }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Supervisor -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Cutting Supervisor</label>
                            <select name="supervisor_id" class="form-select form-select-custom">
                                <option value="">Select Supervisor...</option>
                                @foreach($supervisors as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->supervisor_code }} — {{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Plies & Extra Allowance (Image 4) -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Number of Plies (Image 4)</label>
                            <input type="number" name="no_of_piles" value="100" min="1" required class="form-control form-control-custom fw-bold text-primary">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small uppercase">Extra Qty Allowance</label>
                            <input type="number" name="extra_qty" value="50" min="0" required class="form-control form-control-custom fw-bold text-success">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-b-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-blue px-4">
                        <i class="bi bi-play-circle-fill me-1"></i> Start Laying & Execute Cut Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Active Cutting Floor Operations Table -->
<div class="card-custom mb-4">
    <div class="card-custom-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="card-custom-title mb-0">Active Cutting Orders & Lay Tables</h5>
                <p class="card-custom-subtitle mb-0">Real-time execution status on cutting tables</p>
            </div>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-bold">
                {{ $cutPlans->count() }} Lays Active
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th>Cut Plan No</th>
                        <th>Sales Order / Style</th>
                        <th>CAD Type</th>
                        <th>Plies Count</th>
                        <th>Cut Type</th>
                        <th>Allocation Mode</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cutPlans as $cp)
                    <tr>
                        <td class="fw-bold text-primary">{{ $cp->cut_plan_no }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $cp->salesOrder?->sales_order_no }}</div>
                            <div class="text-muted small" style="font-size:0.7rem;">Style: {{ $cp->salesOrder?->style_no }}</div>
                        </td>
                        <td><span class="badge bg-info-subtle text-info border">{{ $cp->cad_type }} ({{ $cp->unit_of_measure }})</span></td>
                        <td class="fw-bold text-success">{{ $cp->no_of_piles }} Plies</td>
                        <td class="capitalize text-slate-700" style="font-size:0.8rem;">{{ str_replace('_', ' ', $cp->cut_plan_type) }}</td>
                        <td class="capitalize text-slate-500" style="font-size:0.8rem;">{{ str_replace('_', ' ', $cp->group_allocation) }}</td>
                        <td><span class="badge badge-active text-capitalize">{{ str_replace('_', ' ', $cp->status) }}</span></td>
                        <td class="text-center">
                            <span class="badge bg-primary px-3 py-1 cursor-pointer">In Cutting</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No cutting orders active. Click "Start New Cut Order" above to begin.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Numbering & Bundle QR Code Station (Images 4 & 5) -->
<div class="card-custom mb-4">
    <div class="card-custom-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="card-custom-title mb-0">Numbering & Bundle QR Code Station (Images 4 & 5)</h5>
                <p class="card-custom-subtitle mb-0">Generated Lot Bundle Tickets ready for Supermarket / Sewing Line issue</p>
            </div>
            <span class="badge bg-warning text-dark font-bold">{{ $lotBundles->count() }} QR Bundles</span>
        </div>

        <div class="table-responsive">
            <table class="table table-custom align-middle text-sm">
                <thead>
                    <tr>
                        <th>Bundle Ticket No</th>
                        <th>QR Code Hash</th>
                        <th>Size</th>
                        <th>Shade Group</th>
                        <th>Garment Qty</th>
                        <th>Operator / Supervisor</th>
                        <th>Routing Stage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lotBundles as $bnd)
                    <tr>
                        <td class="fw-bold text-primary">{{ $bnd->bundle_no }}</td>
                        <td>
                            <span class="badge bg-light text-dark border font-mono" style="font-size:0.7rem;">
                                <i class="bi bi-qr-code me-1 text-primary"></i> {{ substr($bnd->qr_code_hash, 0, 16) }}...
                            </span>
                        </td>
                        <td><span class="badge bg-secondary font-bold">{{ $bnd->size }}</span></td>
                        <td class="text-info fw-semibold">{{ $bnd->shade_group }}</td>
                        <td class="fw-bold text-success">{{ $bnd->garment_qty }} Pcs</td>
                        <td class="small">
                            <div class="fw-semibold text-dark">{{ $bnd->operator?->name ?? 'Cutter 01' }}</div>
                            <div class="text-muted" style="font-size:0.7rem;">Sup: {{ $bnd->supervisor?->name ?? 'Murugan V' }}</div>
                        </td>
                        <td>
                            <span class="badge bg-info text-uppercase" style="font-size:0.7rem;">
                                {{ str_replace('_', ' ', $bnd->stage) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 5S Methodology Card (Image 2) -->
<div class="card-custom">
    <div class="card-custom-body">
        <h5 class="card-custom-title mb-1">5S Cutting Floor Standard Operating Procedure (Image 2)</h5>
        <p class="card-custom-subtitle mb-3">Enforce high quality standards across cutting tables</p>
        <div class="row g-2 text-center text-xs">
            <div class="col"><div class="p-2 bg-light rounded border fw-bold text-primary">1. Sort (Seiri)</div></div>
            <div class="col"><div class="p-2 bg-light rounded border fw-bold text-primary">2. Set In Order (Seiton)</div></div>
            <div class="col"><div class="p-2 bg-light rounded border fw-bold text-primary">3. Shine (Seiso)</div></div>
            <div class="col"><div class="p-2 bg-light rounded border fw-bold text-primary">4. Standardize (Seiketsu)</div></div>
            <div class="col"><div class="p-2 bg-light rounded border fw-bold text-primary">5. Sustain (Shitsuke)</div></div>
        </div>
    </div>
</div>
@endsection
