<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFabricGroupRequest;
use App\Http\Requests\UpdateFabricGroupRequest;
use App\Models\Fabric;
use App\Models\FabricGroup;
use Illuminate\Http\Request;

class FabricGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = FabricGroup::withCount('fabrics');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('group_code', 'like', "%{$search}%")
                  ->orWhere('group_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $fabricGroups = $query->latest()->paginate(10)->withQueryString();

        return view('fabric_groups.index', compact('fabricGroups', 'search'));
    }

    public function create()
    {
        $fabrics = Fabric::where('status', 'Active')->orderBy('fabric_name')->get();
        return view('fabric_groups.create', compact('fabrics'));
    }

    public function store(StoreFabricGroupRequest $request)
    {
        $data = $request->validated();
        $fabricGroup = FabricGroup::create($data);
        $fabricGroup->fabrics()->sync($request->input('fabrics', []));

        return redirect()->route('fabric-groups.index')->with('success', 'Fabric group created successfully.');
    }

    public function show(FabricGroup $fabricGroup)
    {
        $fabricGroup->load('fabrics');
        $allFabrics = Fabric::where('status', 'Active')->orderBy('fabric_name')->get();

        return view('fabric_groups.show', compact('fabricGroup', 'allFabrics'));
    }

    public function edit(FabricGroup $fabricGroup)
    {
        $fabricGroup->load('fabrics');
        $fabrics = Fabric::orderBy('fabric_name')->get();
        $selectedFabricIds = $fabricGroup->fabrics->pluck('id')->toArray();

        return view('fabric_groups.edit', compact('fabricGroup', 'fabrics', 'selectedFabricIds'));
    }

    public function update(UpdateFabricGroupRequest $request, FabricGroup $fabricGroup)
    {
        $data = $request->validated();
        $fabricGroup->update($data);
        $fabricGroup->fabrics()->sync($request->input('fabrics', []));

        return redirect()->route('fabric-groups.index')->with('success', 'Fabric group updated successfully.');
    }

    public function removeFabric(FabricGroup $fabricGroup, Fabric $fabric)
    {
        $fabricGroup->fabrics()->detach($fabric->id);

        return redirect()->back()->with('success', 'Fabric removed from group successfully.');
    }

    public function addFabrics(Request $request, FabricGroup $fabricGroup)
    {
        $request->validate([
            'fabrics' => ['required', 'array', 'min:1'],
            'fabrics.*' => ['exists:fabrics,id'],
        ]);

        $fabricGroup->fabrics()->syncWithoutDetaching($request->input('fabrics'));

        return redirect()->back()->with('success', 'Fabrics added to group successfully.');
    }

    public function destroy(FabricGroup $fabricGroup)
    {
        if ($fabricGroup->layModels()->exists()) {
            return redirect()->back()->with('error', 'This fabric group is already used in a lay model and cannot be deleted.');
        }

        $fabricGroup->delete();

        return redirect()->route('fabric-groups.index')->with('success', 'Fabric group deleted successfully.');
    }

    public function getFabrics(FabricGroup $fabricGroup)
    {
        return response()->json($fabricGroup->fabrics()->where('status', 'Active')->get());
    }
}
