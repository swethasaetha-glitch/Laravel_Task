@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-sky-600 to-blue-700 rounded-xl p-6 text-white shadow-lg flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Cut Room Planning & Settings</h1>
            <p class="text-sky-100 text-sm mt-1">Configure CAD Markers, Piles, Cut Plan Types & Group Allocations</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-900/40 border border-emerald-500/50 rounded-lg text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- New Cut Plan Form -->
        <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <h2 class="text-lg font-bold text-white mb-4">Create Cut Plan</h2>
            <form action="{{ route('cut-planning.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Sales Order</label>
                    <select name="sales_order_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                        @foreach($salesOrders as $so)
                            <option value="{{ $so->id }}">{{ $so->sales_order_no }} ({{ $so->style_no }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Fabric</label>
                    <select name="fabric_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                        @foreach($fabrics as $fab)
                            <option value="{{ $fab->id }}">{{ $fab->fabric_code }} - {{ $fab->fabric_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">CAD Type</label>
                        <select name="cad_type" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                            <option value="Marker">Marker</option>
                            <option value="Pattern">Pattern</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Unit of Measure</label>
                        <select name="unit_of_measure" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                            <option value="Metres">Metres (Shirts/Denim)</option>
                            <option value="Kg">Kg (Knits)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Cut Plan Type</label>
                    <select name="cut_plan_type" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                        <option value="selected_ratio">Selected Ratio Cut Plan</option>
                        <option value="step_down">Step Down</option>
                        <option value="mini_marker">Mini Marker</option>
                        <option value="selected_size">Selected Size Cut Plan</option>
                        <option value="piles_multiples">Piles Multiples</option>
                        <option value="partial_cut">Partial Cut Plan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Fabric Group Allocation</label>
                    <select name="group_allocation" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                        <option value="automatic">Automatic</option>
                        <option value="factory_cut_plan">Factory Cut Plan</option>
                        <option value="fit_mode">Fit Mode</option>
                        <option value="max_pcs">Max Pcs Cut Plan</option>
                        <option value="piles_adjust">Piles Adjust</option>
                        <option value="equal_size">Equal Size</option>
                        <option value="auto_endbit">Auto Endbit Allocation</option>
                    </select>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">No of Piles</label>
                        <input type="number" name="no_of_piles" value="100" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Order Qty</label>
                        <input type="number" name="order_qty" value="1500" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Extra Qty</label>
                        <input type="number" name="extra_qty" value="50" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                    </div>
                </div>

                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-500 text-white font-semibold py-2 rounded-lg text-sm transition">Generate Cut Plan & Bundles</button>
            </form>
        </div>

        <!-- Cut Plan List -->
        <div class="lg:col-span-2 bg-slate-800/80 border border-slate-700/60 rounded-xl p-6 shadow-xl overflow-x-auto">
            <h2 class="text-lg font-bold text-white mb-4">Active Cut Plans</h2>
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-slate-900/60 text-slate-400">
                    <tr>
                        <th class="p-3">Cut Plan No</th>
                        <th class="p-3">SO & Style</th>
                        <th class="p-3">CAD Type</th>
                        <th class="p-3">Piles</th>
                        <th class="p-3">Plan Type</th>
                        <th class="p-3">Allocation Mode</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @foreach($cutPlans as $cp)
                    <tr>
                        <td class="p-3 font-semibold text-sky-400">{{ $cp->cut_plan_no }}</td>
                        <td class="p-3 text-white">{{ $cp->salesOrder?->sales_order_no }} ({{ $cp->salesOrder?->style_no }})</td>
                        <td class="p-3">{{ $cp->cad_type }} ({{ $cp->unit_of_measure }})</td>
                        <td class="p-3 font-semibold text-emerald-400">{{ $cp->no_of_piles }} Piles</td>
                        <td class="p-3 capitalize">{{ str_replace('_', ' ', $cp->cut_plan_type) }}</td>
                        <td class="p-3 capitalize text-slate-400">{{ str_replace('_', ' ', $cp->group_allocation) }}</td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded text-xs bg-sky-900/60 text-sky-300 border border-sky-700/50 capitalize">
                                {{ str_replace('_', ' ', $cp->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
