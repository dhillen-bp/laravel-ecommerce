<div class="container mx-auto min-h-screen p-4">
    <!-- Heading -->
    <h1 class="mb-6 mt-20 text-center text-3xl font-bold">Keranjang Belanja</h1>

    <!-- Cart Items -->
    <div class="flex flex-col gap-4">
        <!-- Item 1 -->
        <div class="flex items-center justify-between rounded-lg border p-4 shadow">
            <div class="flex items-center gap-4">
                <!-- Product Image -->
                <img src="https://cdn.flyonui.com/fy-assets/components/carousel/image-22.png" alt="Produk"
                    class="h-24 w-24 rounded-md object-cover">
                <!-- Product Details -->
                <div>
                    <h2 class="text-lg font-semibold">Nama Produk</h2>
                    <p class="text-sm text-gray-500">Deskripsi singkat produk</p>
                </div>
            </div>
            <!-- Quantity and Price -->
            <div class="flex items-center gap-4">
                <!-- Quantity Buttons -->
                <div class="flex items-center">
                    <button class="px-2 py-1 text-gray-600 hover:bg-gray-200">-</button>
                    <input type="number" min="1" value="1"
                        class="w-12 border text-center focus:outline-none">
                    <button class="px-2 py-1 text-gray-600 hover:bg-gray-200">+</button>
                </div>
                <!-- Price -->
                <span class="text-lg font-semibold">Rp 123.000</span>
                <!-- Remove Button -->
                <button
                    class="flex items-center justify-center rounded-full border border-red-500 text-red-500 hover:text-red-700">
                    <span class="icon-[tabler--x] h-6 w-6"></span>
                </button>
            </div>
        </div>

        <!-- Add More Items -->
        <div class="text-center">
            <a href="/products" class="text-blue-500 hover:underline">Lanjutkan Belanja</a>
        </div>
    </div>

    <!-- Cart Summary -->
    <div class="mt-6 flex justify-between rounded-lg border p-4 shadow">
        <div>
            <h2 class="text-lg font-semibold">Total</h2>
        </div>
        <div class="text-lg font-bold">Rp 123.000</div>
    </div>

    <!-- Checkout Button -->
    <div class="mt-6 text-center">
        <a href="{{ route('front.checkout') }}"
            class="w-full rounded-lg bg-green-500 px-6 py-2 text-white hover:bg-green-600">
            Lanjut ke Pembayaran
        </a>
    </div>
</div>
