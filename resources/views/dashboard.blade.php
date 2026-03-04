<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="rid grid-cols-2 gap-4">
            <div class="b-white shadow p-4">
                <h3 class="text-gray-500"> Total Products</h3>
                <h3>
                    <p class="text-2x1 font-bold">{{ $totalProducts }}</p>
                </h3>
            </div>
            <div class="b-white shadow p-4">
                <h3 class="text-gray-500"> Total Orders</h3>
                <h3>
                    <p class="text-2x1 font-bold">{{ $totalOrders }}</p>
                </h3>
            </div>
            <div class="b-white shadow p-4">
                <h3 class="text-gray-500"> Total Revenue</h3>
                <h3>
                    <p class="text-2x1 font-bold">₹{{ number_format($totalRevenue, 2) }}</p>
                </h3>
            </div>
            <div class="bg-white shadow p-4 mt-6">
                <h3 class="text-gray-500"> Low Stock Products</h3>
                <table class="w-full border">
                    <tr class="bg-gray-200">
                        <th>Product Name</th>
                        <th>Stock</th>
                    </tr>
                    @foreach($totalStockProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
