<div class="container mx-auto min-h-screen p-4">
    <!-- Heading -->
    <h1 class="mb-6 mt-20 text-center text-3xl font-bold">Checkout</h1>

    <!-- Checkout Form -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <!-- Billing Details -->
        <div class="rounded-lg border p-4 shadow">
            <h2 class="mb-4 text-lg font-semibold">Detail Penagihan</h2>
            <form action="/checkout/confirm" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                        class="w-full rounded border border-gray-300 p-2" placeholder="Masukkan nama lengkap" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full rounded border border-gray-300 p-2" placeholder="Masukkan email" required>
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="address" name="address" class="w-full rounded border border-gray-300 p-2"
                        placeholder="Masukkan alamat pengiriman" rows="3" required></textarea>
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone"
                        class="w-full rounded border border-gray-300 p-2" placeholder="Masukkan nomor telepon" required>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="rounded-lg border p-4 shadow">
            <h2 class="mb-4 text-lg font-semibold">Ringkasan Pesanan</h2>
            <div class="space-y-4">
                <!-- Product 1 -->
                <div class="flex justify-between">
                    <span>Nama Produk</span>
                    <span>Rp 123.000</span>
                </div>
                <!-- Product 2 -->
                <div class="flex justify-between">
                    <span>Nama Produk 2</span>
                    <span>Rp 200.000</span>
                </div>
                <!-- Divider -->
                <div class="h-px bg-gray-300"></div>
                <!-- Total -->
                <div class="flex justify-between font-bold">
                    <span>Total</span>
                    <span>Rp 323.000</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Button -->
    <div class="mt-6 text-center">
        <button class="w-full rounded-lg bg-green-500 px-6 py-2 text-white hover:bg-green-600">
            Bayar Sekarang
        </button>
    </div>
</div>
