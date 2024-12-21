<div class="container mx-auto min-h-screen p-4">
    <h1 class="mb-6 mt-20 text-center text-3xl font-bold">Checkout</h1>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

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
                    <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                    <select id="province" wire:model="province_id" wire:change="fetchCities"
                        class="w-full rounded border border-gray-300 p-2" required>
                        <option value="">Pilih Provinsi</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
                    <select id="city" wire:model="city_id" class="w-full rounded border border-gray-300 p-2"
                        required>
                        <option value="">Pilih Kota</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="address" wire:model='address' class="w-full rounded border border-gray-300 p-2"
                        placeholder="Masukkan alamat pengiriman" rows="3" required></textarea>
                </div>
                <div>
                    <label for="courier_code" class="block text-sm font-medium text-gray-700">Kurir
                        Pengiriman</label>
                    <select id="courier_code" wire:model.live="courier_code"
                        class="w-full rounded border border-gray-300 p-2" required>
                        <option value="">Pilih Kurir</option>
                        <option value="jne">JNE</option>
                        <option value="tiki">TIKI</option>
                        <option value="pos">POS</option>
                    </select>
                </div>
                <div>
                    <label for="selectedCourierOption" class="block text-sm font-medium text-gray-700">Layanan
                        Kurir</label>
                    <div class="flex justify-between gap-3">
                        <div>
                            <select id="selectedCourierOption" wire:model.defer="selectedCourierOption"
                                wire:change="fetchShippingCost" class="w-full rounded border border-gray-300 p-2"
                                required>
                                <option value="" disabled>-Pilih Layanan-</option>
                                @foreach ($courierOptions as $index => $option)
                                    <option value="{{ $index }}">
                                        {{ $option['service'] }} -
                                        Rp {{ number_format($option['cost'][0]['value'], 0, ',', '.') }}
                                        ({{ $option['cost'][0]['etd'] ?? 'N/A' }} hari)
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-sm text-slate-500">Tekan tombol Cek Ongkir untuk menampilkan pilihan
                                kurir</span>
                        </div>
                        <button type="button" wire:click="fetchShippingCost"
                            class="text-nowrap btn btn-primary rounded">
                            Cek Ongkir
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <div class="rounded-lg border p-4 shadow">
            <h2 class="mb-4 text-lg font-semibold">Ringkasan Pesanan</h2>
            <div class="space-y-4">
                <div class="flex items-start justify-between">
                    <div class="flex gap-3">
                        <div>
                            <img src="{{ $selectedVariant->product->image ? formatImageUrl($selectedVariant->product->image) : asset('images/laravel.svg') }}"
                                class="w-16" alt="Product Image">
                        </div>
                        <div>
                            <p class="font-medium">{{ $selectedVariant->product->name }} -
                                {{ $selectedVariant->variant->name }}
                            </p>
                            <p class="text-sm text-gray-500">Qty: 1</p>
                            <p class="text-sm text-gray-500">Harga Satuan: Rp
                                {{ number_format($selectedVariant->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold">Subtotal</p>
                        <p class="font-medium">Rp
                            {{ number_format($selectedVariant->price * 1, 0, ',', '.') }}</p>
                    </div>
                </div>

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

    <div class="mt-6 text-center">
        <button wire:click="submitOrder" class="w-full rounded-lg bg-green-500 px-6 py-2 text-white hover:bg-green-600">
            Lanjutkan Bayar Sekarang
        </button>
    </div>
</div>
