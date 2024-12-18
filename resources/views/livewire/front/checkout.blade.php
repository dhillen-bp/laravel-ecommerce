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
                    <input type="text" id="name" wire:model='name'
                        class="w-full rounded border border-gray-300 p-2" placeholder="Masukkan nama lengkap" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" wire:model='email'
                        class="w-full rounded border border-gray-300 p-2" placeholder="Masukkan email" required>
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="phone" wire:model='phone_number'
                        class="w-full rounded border border-gray-300 p-2" placeholder="Masukkan nomor telepon" required>
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="address" wire:model='shipping_address' class="w-full rounded border border-gray-300 p-2"
                        placeholder="Masukkan alamat pengiriman" rows="3" required></textarea>
                </div>
                <div>
                    <label for="shipping_method" class="block text-sm font-medium text-gray-700">Metode
                        Pengiriman</label>
                    <select id="shipping_method" wire:model="shipping_method" wire:change="updateShippingCost"
                        class="w-full rounded border border-gray-300 p-2" required>
                        <option value="standard">Pengiriman Standar</option>
                        <option value="express">Pengiriman Ekspres</option>
                    </select>
                </div>
                <div>
                    <label for="shipping_cost" class="block text-sm font-medium text-gray-700">Biaya Pengiriman</label>
                    <input type="text" id="shipping_cost" wire:model="shipping_cost"
                        class="w-full rounded border border-gray-300 p-2"
                        value="{{ number_format($shipping_cost, 0, ',', '.') }}" readonly>
                </div>

            </form>
        </div>

        <div class="rounded-lg border p-4 shadow">
            <h2 class="mb-4 text-lg font-semibold">Ringkasan Pesanan</h2>
            <div class="space-y-4">
                @foreach ($cartItems as $item)
                    <div class="flex items-start justify-between">
                        <div class="flex gap-3">
                            <div>
                                <img src="{{ $item->productVariant->product->image ? formatImageUrl($item->productVariant->product->image) : asset('images/laravel.svg') }}"
                                    class="w-16" alt="Product Image">
                            </div>
                            <div>
                                <p class="font-medium">{{ $item->productVariant->product->name }}
                                    - {{ $item->productVariant->variant->name }} </p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                <p class="text-sm text-gray-500">Harga Satuan: Rp
                                    {{ number_format($item->productVariant->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="font-semibold">Subtotal</p>
                            <p class="font-medium">Rp
                                {{ number_format($item->productVariant->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="h-px bg-gray-300"></div>

                <div>
                    <div class="flex justify-between text-sm text-slate-500">
                        <span>Total harga produk + Biaya kirim: </span>
                        <span>
                            <span>Rp {{ number_format($totalProductPrice, 0, ',', '.') }}</span>
                            <span>+</span>
                            <span>Rp {{ number_format($shipping_cost, 0, ',', '.') }}</span>
                        </span>
                    </div>
                    <div class="flex justify-between font-bold">
                        <span>Total</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Button -->
    <div class="mt-6 text-center">
        <button wire:click="submitOrder" class="btn btn-primary w-full">
            Lanjutkan Bayar Sekarang
        </button>
    </div>
</div>
