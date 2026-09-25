<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLayModelRequest;
use App\Http\Requests\UpdateLayModelRequest;
use App\Models\FabricGroup;
use App\Models\LayModel;
use Illuminate\Http\Request;

class LayModelController extends Controller
{
    public function index(Request $request)
    {
        $query = LayModel::with(['fabricGroup', 'fabric']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('lay_model_code', 'like', "%{$search}%")
                  ->orWhere('lay_model_name', 'like', "%{$search}%")
                  ->orWhere('garment_size', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('fabricGroup', function ($gQ) use ($search) {
                      $gQ->where('group_name', 'like', "%{$search}%")
                        ->orWhere('group_code', 'like', "%{$search}%");
                  })
                  ->orWhereHas('fabric', function ($fQ) use ($search) {
                      $fQ->where('fabric_name', 'like', "%{$search}%")
                        ->orWhere('fabric_code', 'like', "%{$search}%");
                  });
            });
        }

        $layModels = $query->latest()->paginate(10)->withQueryString();

        return view('lay_models.index', compact('layModels', 'search'));
    }

    public function create()
    {
        $fabricGroups = FabricGroup::with(['fabrics' => function ($query) {
            $query->where('status', 'Active');
        }])->where('status', 'Active')->get();

        return view('lay_models.create', compact('fabricGroups'));
    }

    public function store(StoreLayModelRequest $request)
    {
        LayModel::create($request->validated());

        return redirect()->route('lay-models.index')->with('success', 'Lay Model created successfully.');
    }

    public function show(LayModel $layModel)
    {
        $layModel->load(['fabricGroup.fabrics', 'fabric']);
        return view('lay_models.show', compact('layModel'));
    }

    public function edit(LayModel $layModel)
    {
        $fabricGroups = FabricGroup::with(['fabrics' => function ($query) {
            $query->where('status', 'Active');
        }])->where('status', 'Active')->get();

        return view('lay_models.edit', compact('layModel', 'fabricGroups'));
    }

    public function update(UpdateLayModelRequest $request, LayModel $layModel)
    {
        $layModel->update($request->validated());

        return redirect()->route('lay-models.index')->with('success', 'Lay Model updated successfully.');
    }

    public function destroy(LayModel $layModel)
    {
        $layModel->delete();

        return redirect()->route('lay-models.index')->with('success', 'Lay Model deleted successfully.');
    }
}
