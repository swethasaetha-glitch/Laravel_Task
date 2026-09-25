@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 border border-sky-500/30 rounded-xl p-6 text-white shadow-xl flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Department-Wise & Machine-Wise Dashboard</h1>
            <p class="text-sky-300 text-sm mt-1">Real-time Working Process Graphs, Daily In-Scan / Out-Scan, Laundry & Quality DHU Audit</p>
        </div>
        <div class="text-right">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-900/60 text-emerald-300 border border-emerald-500/40">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping mr-2"></span> LIVE PRODUCTION
            </span>
        </div>
    </div>

    <!-- Metric Stage Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
        @foreach($stageCounts as $stage => $count)
        <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-4 text-center shadow-lg">
            <p class="text-xs font-semibold uppercase text-slate-400 tracking-wider">{{ $stage }}</p>
            <p class="text-2xl font-extrabold text-white mt-1">{{ $count }}</p>
            <p class="text-[10px] text-sky-400 mt-1">Active Lot Bundles</p>
        </div>
        @endforeach
    </div>

    <!-- Machine In-Scan / Out-Scan Daily Table -->
    <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-6 shadow-xl">
        <h2 class="text-lg font-bold text-white mb-4">Machine-Wise In-Scan / Out-Scan Tracking (Today)</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-slate-900/60 text-slate-400">
                    <tr>
                        <th class="p-3">Machine No</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Department</th>
                        <th class="p-3">Line No</th>
                        <th class="p-3 text-center">In-Scan Today</th>
                        <th class="p-3 text-center">Out-Scan Today</th>
                        <th class="p-3 text-center">Efficiency</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @foreach($machines as $mc)
                    <tr>
                        <td class="p-3 font-semibold text-sky-400">{{ $mc->machine_no }}</td>
                        <td class="p-3 text-white">{{ $mc->machine_name }}</td>
                        <td class="p-3">{{ $mc->department }}</td>
                        <td class="p-3 text-slate-400">{{ $mc->line_no ?? 'Line 1' }}</td>
                        <td class="p-3 text-center font-bold text-emerald-400">{{ $mc->in_scans_today }}</td>
                        <td class="p-3 text-center font-bold text-blue-400">{{ $mc->out_scans_today }}</td>
                        <td class="p-3 text-center">
                            <span class="px-2 py-0.5 rounded text-xs bg-emerald-900/60 text-emerald-300 border border-emerald-700/50">
                                94.5%
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quality DHU & Laundry Tracking Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quality Dashboard -->
        <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-white">Quality Dashboard & DHU Rate</h2>
                <span class="px-3 py-1 rounded bg-rose-900/60 text-rose-300 border border-rose-700/50 text-xs font-bold">
                    DHU Rate: {{ $dhuRate }}%
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="text-xs uppercase bg-slate-900/60 text-slate-400">
                        <tr>
                            <th class="p-2">Bundle</th>
                            <th class="p-2">Defect</th>
                            <th class="p-2">Operator</th>
                            <th class="p-2">Result</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50 text-xs">
                        @foreach($qualityAudits as $qa)
                        <tr>
                            <td class="p-2 font-semibold text-sky-400">{{ $qa->lotBundle?->bundle_no }}</td>
                            <td class="p-2 text-rose-300">{{ $qa->garmentDefect?->defect_name ?? 'None' }}</td>
                            <td class="p-2 text-white">{{ $qa->operator?->name ?? 'System' }}</td>
                            <td class="p-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $qa->audit_result === 'pass' ? 'bg-emerald-900/60 text-emerald-300' : 'bg-rose-900/60 text-rose-300' }}">
                                    {{ $qa->audit_result }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Laundry Management -->
        <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <h2 class="text-lg font-bold text-white mb-4">Laundry & Washing Management</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="text-xs uppercase bg-slate-900/60 text-slate-400">
                        <tr>
                            <th class="p-2">Wash Batch No</th>
                            <th class="p-2">Wash Type</th>
                            <th class="p-2">Status</th>
                            <th class="p-2">Received At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50 text-xs">
                        @foreach($laundryBatches as $lb)
                        <tr>
                            <td class="p-2 font-semibold text-sky-400">{{ $lb->wash_batch_no }}</td>
                            <td class="p-2 text-white">{{ $lb->wash_type }}</td>
                            <td class="p-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-900/60 text-blue-300 border border-blue-700/50">
                                    {{ str_replace('_', ' ', $lb->status) }}
                                </span>
                            </td>
                            <td class="p-2 text-slate-400">{{ $lb->created_at?->format('H:i, d M') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
