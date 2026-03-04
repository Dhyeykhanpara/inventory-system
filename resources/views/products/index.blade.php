<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Products
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div> 
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </span>
        </div>
    @endif

    <div>
        <div>
            <h3 class="text-lg font-medium text-gray-900">Create Product</h3>
            <form id="productForm">
                @csrf

                <div>
                    <input type="text" name="name" placeholder="Product Name" class="border rounded px-3 py-2 w-full">
                        <span class="text-red-500 text-sm" id="name_error"></span>

                    <input type="text" name="sku" placeholder="SKU" class="border rounded px-3 py-2 w-full mt-2">
                        <span class="text-red-500 text-sm" id="sku_error"></span>
                    
                    <input type="number" name="price" placeholder="Price" class="border rounded px-3 py-2 w-full mt-2">
                        <span class="text-red-500 text-sm" id="price_error"></span>

                    <input type="number" name="stock" placeholder="Stock" class="border rounded px-3 py-2 w-full mt-2">
                        <span class="text-red-500 text-sm" id="stock_error"></span>
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 mt-2" type="submit">Save Product</button>
            </form>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#productForm').on('submit',function(e) {
            console.log('Form Submitted');
            
            e.preventDefault();

            $.ajax({
                url: "{{ route('products.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                    $('#productForm')[0].reset();
                },
                error: function(xhr) {
                    if(xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value){
                            $('#' + key + "_error").text(value[0]);
                        });
                    } else {
                    alert('An error occurred while saving the product.');
                    }
                }
            });
        });
    });
</script>