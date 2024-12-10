<div class="container mx-auto min-h-screen p-4">
    <h1 class="mb-6 mt-20 text-center text-3xl font-bold">Pembayaran</h1>

    <div class="rounded-lg border p-4 shadow">
        <h2 class="mb-4 text-lg font-semibold">Rincian Pesanan</h2>
        <div class="space-y-4">
            <p><strong>Nama Lengkap:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}</p>
            <p><strong>Jenis Pengiriman:</strong> {{ $order->shipping_method }}</p>
            <p><strong>Biaya Pengiriman:</strong> {{ $order->shipping_cost }}</p>
        </div>

        <div class="mt-6">
            <h2 class="mb-4 text-lg font-semibold">Produk yang Dibeli</h2>
            <ul class="list-disc space-y-2 pl-6">
                @foreach ($order->orderItems as $item)
                    <li>
                        <span><strong>{{ $item->product->name }}</strong></span> -
                        <span>{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6">
            <div class="flex items-center justify-between">
                <span><strong>Total Pembayaran:</strong></span>
                <div class="flex flex-col justify-end">
                    <p>Rp {{ number_format($order->price, 0, ',', '.') }} + Rp
                        {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                    <p class="self-end font-semibold">Rp
                        {{ number_format($order->price + $order->shipping_cost, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            @livewire('front.midtrans-payment', ['orderId' => $order->id])
        </div>

    </div>

</div>
