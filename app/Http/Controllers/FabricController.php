<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFabricRequest;
use App\Http\Requests\UpdateFabricRequest;
use App\Models\Fabric;
use Illuminate\Http\Request;

class FabricController extends Controller
{
    public function index(Request $request)
    {
        $query = Fabric::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('fabric_code', 'like', "%{$search}%")
                  ->orWhere('fabric_name', 'like', "%{$search}%")
                  ->orWhere('fabric_type', 'like', "%{$search}%")
                  ->orWhere('composition', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $fabrics = $query->latest()->paginate(10)->withQueryString();

        return view('fabrics.index', compact('fabrics', 'search'));
    }

    public function create()
    {
        return view('fabrics.create');
    }

    public function store(StoreFabricRequest $request)
    {
        Fabric::create($request->validated());

        return redirect()->route('fabrics.index')->with('success', 'Fabric created successfully.');
    }

    public function show(Fabric $fabric)
    {
        $fabric->load(['groups', 'layModels']);
        return view('fabrics.show', compact('fabric'));
    }

    public function edit(Fabric $fabric)
    {
        return view('fabrics.edit', compact('fabric'));
    }

    public function update(UpdateFabricRequest $request, Fabric $fabric)
    {
        $fabric->update($request->validated());

        return redirect()->route('fabrics.index')->with('success', 'Fabric updated successfully.');
    }

    public function destroy(Fabric $fabric)
    {
        if ($fabric->layModels()->exists()) {
            return redirect()->back()->with('error', 'This fabric is already used in a lay model and cannot be deleted.');
        }

        if ($fabric->groups()->exists()) {
            return redirect()->back()->with('error', 'This fabric is assigned to a fabric group and cannot be deleted.');
        }

        $fabric->delete();

        return redirect()->route('fabrics.index')->with('success', 'Fabric deleted successfully.');
    }
}
