<div class="container mx-auto min-h-screen p-4">
    <div class="mt-20 flex justify-center">
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-white">
                    1
                </div>
                <span class="ml-2 text-sm font-medium text-gray-800">Checkout Order</span>
            </div>

            <div class="h-1 w-20 bg-gray-300"></div>

            <div class="flex items-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-300 text-gray-600">
                    2
                </div>
                <span class="ml-2 text-sm font-medium text-gray-400">Payment Process</span>
            </div>
        </div>
    </div>

    <h1 class="mb-6 mt-5 text-center text-3xl font-bold">Checkout Order</h1>

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
                            <span class="text-sm text-slate-500">Pilih Kurir & Tekan tombol Cek Ongkir untuk
                                menampilkan pilihan
                                kurir</span>
                        </div>
                        <button type="button" wire:click="fetchShippingCost"
                            class="btn btn-primary text-nowrap rounded">
                            Cek Ongkir
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <div class="space-y-3 md:space-y-5">
            <div class="rounded-lg border p-4 shadow">
                <h2 class="mb-4 text-lg font-semibold">Kode Voucher</h2>
                <div class="flex items-center space-x-4">
                    <form class="flex w-full gap-x-5">
                        <input type="text" wire:model.defer="voucher.code" placeholder="Masukkan kode voucher"
                            class="w-full rounded border border-gray-300 pl-2" />
                        <button type="button" wire:click="applyVoucher" class="btn btn-primary rounded">
                            Terapkan
                        </button>
                    </form>
                </div>
                @if ($voucher['error'])
                    <p class="mt-2 text-sm text-error">{{ $voucher['error'] }}</p>
                @endif
                @if ($voucher['amount'] > 0)
                    <p class="mt-2 text-sm text-green-500">Anda mendapatkan diskon: Rp
                        {{ number_format($voucher['amount'], 0, ',', '.') }}</p>
                @endif
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
                        @if (!empty($voucher['code'] && $voucher['amount']))
                            <div class="flex justify-between text-sm text-slate-500">
                                <span>Total harga produk (Sebelum Diskon): </span>
                                <span>Rp
                                    {{ number_format($totalProductPrice + ($voucher['amount'] ?? 0), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-slate-500">
                                <span>Total harga produk (Setelah Diskon): </span>
                                <span class="line-through">Rp
                                    {{ number_format($totalProductPrice, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm text-slate-500">
                            <span>Total harga produk + Ongkos kirim: </span>
                            <span>
                                <span>Rp {{ number_format($totalProductPrice, 0, ',', '.') }}</span>
                                <span>+</span>
                                <span>Rp {{ number_format($shipping_cost, 0, ',', '.') }}</span>
                            </span>
                        </div>
                        <div class="flex justify-between font-bold">
                            <span>Total</span>
                            <span>Rp {{ number_format($totalOrderPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 text-center">
        <button wire:click="submitOrder" @if (empty($courier_code) && empty($courierOptions) && empty($selectedCourierOption)) disabled @endif
            class="@if (empty($courier_code) && empty($courierOptions) && empty($selectedCourierOption)) disabled @endif btn btn-primary w-full rounded-full">
            Lakukan Checkout
        </button>
    </div>
</div>
