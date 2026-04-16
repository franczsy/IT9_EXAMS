<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 

class PaymentController extends Controller
{

    public function process(Request $request, Order $order)
    {
        if ($order->isPaid()) {
            return back()->with('error', 'This order is already paid.');
        }

        $request->validate([
            'amount_paid' => 'required|numeric|min:' . $order->total_amount,
            'payment_method' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $order) {
            Payment::create([
                'order_id' => $order->id,
                'amount_paid' => $order->total_amount,
                'payment_method' => $request->payment_method,
                'payment_date' => now(),
                'notes' => $request->notes,
            ]);
            $order->update(['payment_status' => 'paid']);
        });

        return redirect()->route('orders.show', $order)->with('success', 'Payment recorded successfully.');
    }

    public function history()
    {
        $payments = Payment::with('order.user')->latest()->paginate(10);
        return view('payments.history', compact('payments'));
    }
}