@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-sky-600 to-blue-700 rounded-xl p-6 text-white shadow-lg flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Garment Master Management</h1>
            <p class="text-sky-100 text-sm mt-1">Configure Style Sequences, Machine Masters, Operators, Defects, and Shade Groups</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-900/40 border border-emerald-500/50 rounded-lg text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Master Navigation Tabs -->
    <div class="border-b border-slate-700/60 flex gap-4 overflow-x-auto pb-2">
        <a href="{{ route('masters.index', ['tab' => 'styles']) }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition {{ $tab === 'styles' ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-slate-800' }}">Styles & Sequence</a>
        <a href="{{ route('masters.index', ['tab' => 'machines']) }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition {{ $tab === 'machines' ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-slate-800' }}">Machine Master</a>
        <a href="{{ route('masters.index', ['tab' => 'operators']) }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition {{ $tab === 'operators' ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-slate-800' }}">Operators</a>
        <a href="{{ route('masters.index', ['tab' => 'supervisors']) }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition {{ $tab === 'supervisors' ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-slate-800' }}">Supervisors</a>
        <a href="{{ route('masters.index', ['tab' => 'defects']) }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition {{ $tab === 'defects' ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-slate-800' }}">Garment Defects</a>
        <a href="{{ route('masters.index', ['tab' => 'shades']) }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition {{ $tab === 'shades' ? 'bg-sky-600 text-white' : 'text-slate-400 hover:bg-slate-800' }}">Shade Master</a>
    </div>

    <!-- TAB 1: STYLES -->
    @if($tab === 'styles')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <h2 class="text-lg font-bold text-white mb-4">Create New Style</h2>
            <form action="{{ route('masters.styles.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Style No</label>
                    <input type="text" name="style_no" placeholder="e.g. ST-990" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:border-sky-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Style Name</label>
                    <input type="text" name="style_name" placeholder="e.g. Mens Crewneck T-Shirt" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:border-sky-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Garment Type</label>
                    <select name="garment_type" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:border-sky-500">
                        <option value="Shirts">Shirts / Polos</option>
                        <option value="Denim">Denim / Jeans</option>
                        <option value="Knits">Knits / T-Shirts</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">SAM (Minutes)</label>
                    <input type="number" step="0.01" name="sam" value="22.50" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm focus:border-sky-500">
                </div>
                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-500 text-white font-semibold py-2 rounded-lg text-sm transition">Save Style & Auto-Generate Process Sequence</button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-slate-800/80 border border-slate-700/60 rounded-xl p-6 shadow-xl overflow-x-auto">
            <h2 class="text-lg font-bold text-white mb-4">Style Master Catalog</h2>
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-slate-900/60 text-slate-400">
                    <tr>
                        <th class="p-3">Style No</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">SAM</th>
                        <th class="p-3">Process Steps</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @foreach($styles as $style)
                    <tr>
                        <td class="p-3 font-semibold text-sky-400">{{ $style->style_no }}</td>
                        <td class="p-3 text-white">{{ $style->style_name }}</td>
                        <td class="p-3">{{ $style->garment_type }}</td>
                        <td class="p-3 text-emerald-400">{{ $style->sam }} mins</td>
                        <td class="p-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-900/60 text-blue-300 border border-blue-700/50">
                                {{ $style->processSequences->count() }} Steps Defined
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- TAB 2: MACHINES -->
    @if($tab === 'machines')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <h2 class="text-lg font-bold text-white mb-4">Add Machine</h2>
            <form action="{{ route('masters.machines.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Machine No</label>
                    <input type="text" name="machine_no" placeholder="MC-SEW-201" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Name</label>
                    <input type="text" name="machine_name" placeholder="Juki Overlock 4 Thread" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Type</label>
                    <input type="text" name="machine_type" placeholder="Overlock" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Department</label>
                    <select name="department" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white text-sm">
                        <option value="Cutting">Cutting</option>
                        <option value="Sewing">Sewing</option>
                        <option value="Washing">Washing</option>
                        <option value="Finishing">Finishing</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-500 text-white font-semibold py-2 rounded-lg text-sm transition">Save Machine</button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-slate-800/80 border border-slate-700/60 rounded-xl p-6 shadow-xl overflow-x-auto">
            <h2 class="text-lg font-bold text-white mb-4">Machine Master List</h2>
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase bg-slate-900/60 text-slate-400">
                    <tr>
                        <th class="p-3">Machine No</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Department</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @foreach($machines as $m)
                    <tr>
                        <td class="p-3 font-semibold text-sky-400">{{ $m->machine_no }}</td>
                        <td class="p-3 text-white">{{ $m->machine_name }}</td>
                        <td class="p-3">{{ $m->department }}</td>
                        <td class="p-3">{{ $m->machine_type }}</td>
                        <td class="p-3"><span class="px-2 py-0.5 rounded text-xs bg-emerald-900/60 text-emerald-300 border border-emerald-700/50">Active</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
