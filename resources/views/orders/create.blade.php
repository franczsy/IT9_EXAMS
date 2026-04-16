<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create New Order') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('orders.store') }}" id="orderForm">
                        @csrf
                        <div id="orderItemsContainer">
                            <div class="order-item mb-4 p-4 border rounded">
                                <div class="mb-2">
                                    <label class="block text-sm font-bold mb-1">Rice Product</label>
                                    <select name="items[0][rice_item_id]" class="rice-select w-full border rounded py-2 px-3" required>
                                        <option value="">Select Rice</option>
                                        @foreach($riceItems as $rice)
                                            <option value="{{ $rice->id }}" data-price="{{ $rice->price_per_kg }}">{{ $rice->name }} - ₱{{ number_format($rice->price_per_kg, 2) }}/kg</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-bold mb-1">Quantity (kg)</label>
                                    <input type="number" step="0.1" name="items[0][quantity_kg]" class="quantity w-full border rounded py-2 px-3" required>
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-bold mb-1">Subtotal</label>
                                    <input type="text" class="subtotal w-full border rounded py-2 px-3 bg-gray-100" readonly>
                                </div>
                                <button type="button" class="remove-item bg-red-500 text-white px-2 py-1 rounded">Remove</button>
                            </div>
                        </div>
                        <button type="button" id="addItemBtn" class="bg-green-500 text-white px-4 py-2 rounded mb-4">Add Another Rice</button>
                        <div class="mt-4">
                            <label class="block text-sm font-bold mb-1">Order Total</label>
                            <input type="text" id="orderTotal" class="w-full border rounded py-2 px-3 bg-gray-100" readonly>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Place Order</button>
                            <a href="{{ route('orders.index') }}" class="text-gray-600">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let itemIndex = 1;
        document.getElementById('addItemBtn').addEventListener('click', function() {
            const container = document.getElementById('orderItemsContainer');
            const newItem = container.children[0].cloneNode(true);
            newItem.querySelectorAll('input, select').forEach(el => {
                const name = el.getAttribute('name');
                if (name) el.setAttribute('name', name.replace(/\[\d+\]/, `[${itemIndex}]`));
                if (el.type !== 'button') el.value = '';
            });
            container.appendChild(newItem);
            itemIndex++;
            attachEventsToItem(newItem);
        });

        function attachEventsToItem(item) {
            const select = item.querySelector('.rice-select');
            const qty = item.querySelector('.quantity');
            const subtotalField = item.querySelector('.subtotal');
            function updateSubtotal() {
                const price = select.options[select.selectedIndex]?.getAttribute('data-price') || 0;
                const qtyVal = parseFloat(qty.value) || 0;
                subtotalField.value = (price * qtyVal).toFixed(2);
                updateTotal();
            }
            select.addEventListener('change', updateSubtotal);
            qty.addEventListener('input', updateSubtotal);
            item.querySelector('.remove-item')?.addEventListener('click', function() {
                if (document.querySelectorAll('.order-item').length > 1) item.remove();
                else alert('At least one rice item required.');
                updateTotal();
            });
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(field => {
                total += parseFloat(field.value) || 0;
            });
            document.getElementById('orderTotal').value = total.toFixed(2);
        }

        document.querySelectorAll('.order-item').forEach(attachEventsToItem);
    </script>
</x-app-layout>