<x-app-layout>
    <x-slot name="header"><h2>Orders</h2></x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('orders.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block mb-4">New Order</a>
                @if(session('success'))<div class="bg-green-100 p-2 mb-2">{{ session('success') }}</div>@endif
                <table class="min-w-full">

                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="text-center">{{ $order->id }}</td>
                            <td class="text-center">{{ $order->user->name }}</td>
                            <td class="text-center">₱{{ number_format($order->total_amount,2) }}</td>
                            <td class="text-center">{{ ucfirst($order->payment_status) }}</td>
                            <td class="text-center">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-center"><a href="{{ route('orders.show', $order) }}" class="text-blue-600">View</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>