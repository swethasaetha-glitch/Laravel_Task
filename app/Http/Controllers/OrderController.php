<?php

namespace App\Http\Controllers;

use App\Models\BuyerOrder;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function buyerOrders()
    {
        $buyerOrders = BuyerOrder::with('salesOrders')->latest()->get();
        return view('orders.buyer_orders', compact('buyerOrders'));
    }

    public function storeBuyerOrder(Request $request)
    {
        $validated = $request->validate([
            'buyer_name' => ['required', 'string', 'max:255'],
            'po_number' => ['required', 'string', 'max:100', 'unique:buyer_orders,po_number'],
            'order_date' => ['required', 'date'],
            'delivery_date' => ['required', 'date'],
            'total_garment_qty' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string'],
        ]);

        BuyerOrder::create($validated);

        return redirect()->back()->with('success', 'Buyer Order created successfully!');
    }

    public function salesOrders()
    {
        $salesOrders = SalesOrder::with('buyerOrder')->latest()->get();
        $buyerOrders = BuyerOrder::where('status', 'Confirmed')->get();
        return view('orders.sales_orders', compact('salesOrders', 'buyerOrders'));
    }

    public function storeSalesOrder(Request $request)
    {
        $validated = $request->validate([
            'sales_order_no' => ['required', 'string', 'max:100', 'unique:sales_orders,sales_order_no'],
            'buyer_order_id' => ['required', 'exists:buyer_orders,id'],
            'style_no' => ['required', 'string', 'max:100'],
            'garment_type' => ['required', 'string', 'max:100'],
            'colorway' => ['required', 'string', 'max:100'],
            'size_ratio' => ['nullable', 'string', 'max:100'],
            'order_qty' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string'],
        ]);

        SalesOrder::create($validated);

        return redirect()->back()->with('success', 'Sales Order created successfully!');
    }
}
