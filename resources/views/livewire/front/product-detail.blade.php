<div class="mx-auto max-w-7xl p-6 lg:p-8">
    <!-- Product Detail Section -->
    <div class="mb-6 mt-20 grid grid-cols-1 gap-8 md:grid-cols-2">
        <!-- Left: Product Image -->
        <div class="flex justify-center">
            <img src="{{ $product->image != null ? Storage::url($product->image) : asset('images/laravel.svg') }}"
                alt="Product Image" class="max-h-[500px] w-full rounded-lg object-cover shadow-lg md:h-auto md:w-full">
        </div>

        <!-- Right: Product Info -->
        <div class="space-y-6">
            <!-- Product Name -->
            <h1 class="text-3xl font-semibold text-gray-800">{{ $product->name }}</h1>

            <!-- Product Price -->
            <p class="text-2xl font-bold text-gray-900">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>

            <!-- Product Description -->
            <p class="text-gray-600">
                {{ $product->description }}
            </p>

            <!-- Product Specifications / Details -->
            <div class="space-y-2">
                <div class="flex items-center">
                    <span class="font-semibold text-gray-700">Ukuran:</span>
                    <span class="ml-2 text-gray-600">M, L, XL</span>
                </div>
                <div class="flex items-center">
                    <span class="font-semibold text-gray-700">Stok:</span>
                    <span class="ml-2 text-gray-600">{{ $product->stock }}</span>
                </div>
            </div>

            <!-- Quantity and Add to Cart Button -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center rounded-md border border-gray-300">
                    <button id="decrease" class="px-4 py-2 text-gray-600 hover:bg-gray-200">-</button>
                    <input id="quantity" type="number" min="1" value="1"
                        class="w-12 border-b border-t border-gray-300 py-2 text-center text-lg focus:outline-none">
                    <button id="increase" class="px-4 py-2 text-gray-600 hover:bg-gray-200">+</button>
                </div>
                <button
                    class="hover:bg-primary-dark rounded-lg bg-primary px-6 py-2 font-semibold text-white focus:outline-none">
                    Tambah ke Keranjang
                </button>
            </div>

            <!-- Product Ratings -->
            <div class="flex items-center space-x-2">
                <span class="text-yellow-500">⭐⭐⭐⭐⭐</span>
                <span class="text-gray-600">(100 Ulasan)</span>
            </div>
        </div>
    </div>

    <!-- Recommended Products -->
    <section class="mt-12">
        <h2 class="text-2xl font-semibold text-gray-800">Produk Terkait</h2>
        <div class="mt-4 grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-4">
            <!-- Product 1 -->
            <div class="rounded-lg border p-4">
                <img src="https://cdn.flyonui.com/fy-assets/components/carousel/image-22.png"
                    class="mb-4 h-48 w-full rounded-lg object-cover" alt="Product 1">
                <h3 class="text-lg font-semibold text-gray-800">Kaos Polos Merah</h3>
                <p class="text-gray-600">Rp. 120.000</p>
            </div>
            <!-- Product 2 -->
            <div class="rounded-lg border p-4">
                <img src="https://cdn.flyonui.com/fy-assets/components/carousel/image-22.png"
                    class="mb-4 h-48 w-full rounded-lg object-cover" alt="Product 2">
                <h3 class="text-lg font-semibold text-gray-800">Kaos Polos Hitam</h3>
                <p class="text-gray-600">Rp. 130.000</p>
            </div>
            <!-- Add more products here -->
        </div>
    </section>

    <!-- Shipping & Warranty -->
    <section class="mt-12 border-t pt-6">
        <h2 class="text-2xl font-semibold text-gray-800">Informasi Pengiriman & Garansi</h2>
        <p class="text-gray-600">Pengiriman gratis untuk semua pesanan di atas Rp. 200.000. Garansi 30 hari untuk produk
            cacat manufaktur.</p>
    </section>
</div>

@push('after-script')
    <script>
        console.log("after scriot");
        // Ambil elemen input dan tombol
        const quantityInput = document.getElementById('quantity');
        const decreaseButton = document.getElementById('decrease');
        const increaseButton = document.getElementById('increase');

        // Fungsi untuk mengurangi jumlah
        decreaseButton.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) { // Pastikan tidak kurang dari 1
                quantityInput.value = currentValue - 1;
            }
        });

        // Fungsi untuk menambah jumlah
        increaseButton.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });
    </script>
@endpush
