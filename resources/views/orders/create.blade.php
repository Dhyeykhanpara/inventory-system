<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Order
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    
    @endif

    <div class="py-6">
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <input type="text" name="customer_name" placeholder="Customer Name" required class="border rounded px-3 py-2 w-full">

            <table class="w-full border" id="orderTable">
                <tr class="bg-gray-200">
                    <th>
                        Product
                    </th>
                    <th>
                        Quantity
                    </th>
                    <th>
                        Price
                    </th>
                    <th></th>
                </tr>

                <tr>
                    <td>
                        <select name="product_id[]" class="product border p-2">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="quantity[]" placeholder="Quantity" required class="qty border rounded px-3 py-2 w-full">
                    </td>
                    <td class="price">
                        0
                    </td>
                    <td>
                        <button type="button" class="addRow bg-green-500 text-white px-2">+</button>
                    </td>
                </tr>
            </table>

            <h3 class="mt-4 text-lg">
                Total: ₹ <span id="total">0</span>
            </h3>

            <button class="bg-blue-600 text-white px-4 py-2 mt-4" type="submit">Place Order</button>
        </form>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function calculateTotal() {
        let total = 0;
        $('#orderTable tr').each(function() {
            let price = $(this).find(".product option:selected").data("price");

            let qt = $(this).find(".qty").val();

            if(price && qt) {
                let rowTotal = price * qt;

                $(this).find(".price").text(rowTotal);

                total += rowTotal;
            }
        });
        $('#total').text(total);
    }

    $(document).on("input keyup", ".product, .qty", function(){
        calculateTotal();
    });

    $(document).on("click", ".addRow", function(){
        let row = $("#orderTable tr:eq(1)").clone();
        $("#orderTable").append(row);
    })

    </script>