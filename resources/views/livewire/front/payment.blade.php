<div class="container mx-auto min-h-screen p-4">
    <div class="mt-20 flex justify-center">
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-success text-gray-50">
                    <span class="icon-[tabler--check] size-4"></span>
                </div>
                <span class="ml-2 text-sm font-medium text-success text-opacity-65">Checkout Order</span>
            </div>

            <div class="h-1 w-20 bg-gray-300"></div>

            <div class="flex items-center">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-white">
                    2
                </div>
                <span class="ml-2 text-sm font-medium text-gray-800">Payment Process</span>
            </div>
        </div>
    </div>

    <h1 class="mb-6 mt-5 text-center text-3xl font-bold">Payment Process</h1>

    <div class="rounded-lg border p-4 shadow">
        <h2 class="mb-4 text-lg font-semibold">Rincian Pesanan</h2>
        <div class="space-y-4">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Nama Lengkap:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Alamat Pengiriman:</strong>
                {{ $order->shipping->address . ', Kota: ' . $order->shipping->city->name . ', Provinsi: ' . $order->shipping->province->name }}
            </p>
            <p><strong>Kurir Pengiriman:</strong> {{ $order->shipping->courier_name }}</p>
            <p><strong>Layanan Kurir:</strong>
                {{ $order->shipping->courier_service . ' (' . $order->shipping->estimate_day . 'hari)' }}</p>
            <p><strong>Biaya Pengiriman:</strong> Rp {{ number_format($order->shipping->cost, 0, ',', '.') }}</p>
        </div>

        <div class="mt-6">
            <h2 class="mb-4 text-lg font-semibold">Produk yang Dibeli</h2>
            <ul class="list-disc space-y-2 pl-6">
                @foreach ($order->order_items as $item)
                    <li>
                        <span><strong>{{ $item->product_variant->product->name }}
                                ({{ $item->product_variant->variant->name }})
                            </strong></span> -
                        <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6">
            <div class="flex items-center justify-between">
                <div>
                    @if (!empty($order->discount_code))
                        <p>Total Harga Produk (sebelum diskon):</p>
                        <p>Total Harga Produk (setelah diskon):</p>
                    @endif
                    <p>Total Harga Produk + Ongkos Kirim:</p>
                    <p><strong>Total Pembayaran:</strong></p>
                </div>
                <div class="flex flex-col justify-end">
                    @if (!empty($order->discount_code))
                        <p class="self-end line-through">Rp
                            {{ number_format($order->total_product_price + $order->discount_amount, 0, ',', '.') }}
                        </p>
                        <p class="self-end">Rp {{ number_format($order->total_product_price, 0, ',', '.') }}
                        </p>
                    @endif
                    <p class="self-end">Rp {{ number_format($order->total_product_price, 0, ',', '.') }} + Rp
                        {{ number_format($order->shipping->cost, 0, ',', '.') }}</p>
                    <p class="self-end font-semibold">Rp
                        {{ number_format($order->price + $order->total_order_price, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            @livewire('front.midtrans-payment', ['orderId' => $order->id])
        </div>

    </div>

</div>
