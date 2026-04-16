<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rice Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('rice-items.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Add New Rice</a>
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                    @endif
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider ">Name</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Price/kg</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stock (kg)</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($riceItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $item->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">₱{{ number_format($item->price_per_kg, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $item->stock_quantity }}</td>
                                <td class="px-6 py-4 text-center">{{ $item->description }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('rice-items.edit', $item) }}" class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                                        <form action="{{ route('rice-items.destroy', $item) }}" method="POST" class="inline-block">
                                             @csrf @method('DELETE')
                                     <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Delete this item?')">Delete</button>
                                        </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>