<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Rice Product') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('rice-items.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Rice Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Price per Kilogram</label>
                            <input type="number" step="0.01" name="price_per_kg" value="{{ old('price_per_kg') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            @error('price_per_kg') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Stock Quantity (kg)</label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                            @error('stock_quantity') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">{{ old('description') }}</textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                            <a href="{{ route('rice-items.index') }}" class="text-gray-600">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>