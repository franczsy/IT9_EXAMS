<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RiceItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $riceItems = RiceItem::all();
        return view('orders.create', compact('riceItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.rice_item_id' => 'required|exists:rice_items,id',
            'items.*.quantity_kg' => 'required|numeric|min:0.1',
        ]);

        DB::transaction(function () use ($request) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => 0,
                'payment_status' => 'unpaid',
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $rice = RiceItem::findOrFail($item['rice_item_id']);
                $subtotal = $rice->price_per_kg * $item['quantity_kg'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'rice_item_id' => $rice->id,
                    'quantity_kg' => $item['quantity_kg'],
                    'price_per_kg_at_time' => $rice->price_per_kg,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
                // Reduce stock
                $rice->decrement('stock_quantity', $item['quantity_kg']);
            }
            $order->update(['total_amount' => $total]);
        });

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load('orderItems.riceItem', 'user', 'payments');
        return view('orders.show', compact('order'));
    }
}