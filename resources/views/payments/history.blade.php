<x-app-layout>
    <x-slot name="header"><h2>Payment History</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full">

                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Order ID</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Method</th>
                            <th class="text-center">Notes</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td class="text-center">{{ $payment->payment_date }}</td>
                            <td class="text-center"><a href="{{ route('orders.show', $payment->order) }}" class="text-blue-600">#{{ $payment->order_id }}</a></td>
                            <td class="text-center">{{ $payment->order->user->name }}</td>
                            <td class="text-center">₱{{ number_format($payment->amount_paid,2) }}</td>
                            <td class="text-center">{{ ucfirst($payment->payment_method) }}</td>
                            <td class="text-center">{{ $payment->notes }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>