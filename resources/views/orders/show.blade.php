<x-app-layout>
    <x-slot name="header"><h2>Order #{{ $order->id }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold">Order Items</h3>
                <table class="min-w-full mb-4">
                    <thead>
                        <tr>
                        <th class="text-center">Rice</th>
                            <th class="text-center">Quantity (kg)</th>
                            <th class="text-center">Price/kg</th>
                            <th class="text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="text-center">{{ $item->riceItem->name }}</td>
                            <td class="text-center">{{ $item->quantity_kg }}</td>
                            <td class="text-center">₱{{ number_format($item->price_per_kg_at_time,2) }}</td>
                            <td class="text-center">₱{{ number_format($item->subtotal,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p><strong>Total Amount:</strong> ₱{{ number_format($order->total_amount,2) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</p>

                @if(!$order->isPaid())
                <div class="mt-4 p-4 border rounded bg-gray-50">
                    <h4 class="font-bold">Process Payment</h4>
                    <form method="POST" action="{{ route('payments.process', $order) }}">
                        @csrf
                        <div class="mb-2">
                            <label>Amount Paid</label>
                            <input type="number" step="0.01" name="amount_paid" value="{{ $order->total_amount }}" class="border rounded w-full p-2" required>
                        </div>
                        <div class="mb-2">
                            <label>Payment Method</label>
                            <select name="payment_method" class="border rounded w-full p-2">
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Notes</label>
                            <textarea name="notes" class="border rounded w-full p-2"></textarea>
                        </div>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Record Payment</button>
                    </form>
                </div>
                @else
                <div class="mt-4 p-4 bg-green-100 rounded">This order is already paid.</div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('orders.index') }}" class="text-blue-600">Back to Orders</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>