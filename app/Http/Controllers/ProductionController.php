<?php

namespace App\Http\Controllers;

use App\Models\ProductionBundle;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function bundles(Request $request)
    {
        $query = ProductionBundle::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('bundle_no', 'like', "%{$search}%")
                  ->orWhere('buyer', 'like', "%{$search}%")
                  ->orWhere('style_no', 'like', "%{$search}%")
                  ->orWhere('order_no', 'like', "%{$search}%")
                  ->orWhere('garment', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($garment = $request->input('garment')) {
            $query->where('garment', 'like', "%{$garment}%");
        }

        if ($quantity = $request->input('quantity')) {
            if ($quantity === 'high') {
                $query->orderBy('total_qty', 'desc');
            } elseif ($quantity === 'low') {
                $query->orderBy('total_qty', 'asc');
            }
        } else {
            $query->latest();
        }

        $bundles = $query->get();

        $totalBundles = $bundles->count();
        $totalQuantity = $bundles->sum('total_qty');
        $completedQuantity = $bundles->sum('completed_qty');
        $rejectedQuantity = $bundles->sum('rejected_qty');

        return view('production.bundles', compact(
            'bundles',
            'totalBundles',
            'totalQuantity',
            'completedQuantity',
            'rejectedQuantity'
        ));
    }

    public function storeBundle(Request $request)
    {
        $validated = $request->validate([
            'bundle_no' => ['required', 'string', 'max:50', 'unique:production_bundles,bundle_no'],
            'buyer' => ['required', 'string', 'max:100'],
            'style_no' => ['required', 'string', 'max:100'],
            'order_no' => ['required', 'string', 'max:100'],
            'garment' => ['required', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:50'],
            'size' => ['nullable', 'string', 'max:50'],
            'total_qty' => ['required', 'integer', 'min:1'],
            'completed_qty' => ['nullable', 'integer', 'min:0'],
            'rejected_qty' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:Active,Completed,Pending'],
        ]);

        ProductionBundle::create($validated);

        return redirect()->route('production.bundles')->with('success', 'Production bundle created successfully!');
    }

    public function destroyBundle(ProductionBundle $bundle)
    {
        $bundle->delete();
        return redirect()->route('production.bundles')->with('success', 'Production bundle deleted successfully!');
    }

    public function cutting()
    {
        return view('production.cutting');
    }

    public function sewing()
    {
        return view('production.sewing');
    }

    public function quality()
    {
        return view('production.quality');
    }

    public function packing()
    {
        return view('production.packing');
    }
}
