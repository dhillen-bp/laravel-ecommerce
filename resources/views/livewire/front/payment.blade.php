<div class="container mx-auto min-h-screen p-4">
    <h1 class="mb-6 mt-20 text-center text-3xl font-bold">Pembayaran</h1>

    <div class="rounded-lg border p-4 shadow">
        <h2 class="mb-4 text-lg font-semibold">Rincian Pesanan</h2>
        <div class="space-y-4">
            <p><strong>Nama Lengkap:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Alamat Pengiriman:</strong>
                {{ $order->shipping->address . ', Kota: ' . $order->shipping->city->name . ', Provinsi: ' . $order->shipping->province->name }}
            </p>
            <p><strong>Kurir Pengiriman:</strong> {{ $order->shipping->courier_name }}</p>
            <p><strong>Layanan Kurir:</strong>
                {{ $order->shipping->courier_service . ' (' . $order->shipping->estimate_day . 'hari)' }}</p>
            <p><strong>Biaya Pengiriman:</strong> {{ $order->shipping->cost }}</p>
        </div>

        <div class="mt-6">
            <h2 class="mb-4 text-lg font-semibold">Produk yang Dibeli</h2>
            <ul class="list-disc space-y-2 pl-6">
                @foreach ($order->orderItems as $item)
                    <li>
                        <span><strong>{{ $item->productVariant->product->name }}
                                ({{ $item->productVariant->variant->name }})
                            </strong></span> -
                        <span>{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6">
            <div class="flex items-center justify-between">
                <span><strong>Total Pembayaran:</strong></span>
                <div class="flex flex-col justify-end">
                    <p>Rp {{ number_format($order->total_product_price, 0, ',', '.') }} + Rp
                        {{ number_format($order->shipping->cost, 0, ',', '.') }}</p>
                    <p class="self-end font-semibold">Rp
                        {{ number_format($order->price + $order->total_price, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            @livewire('front.midtrans-payment', ['orderId' => $order->id])
        </div>

    </div>

</div>
