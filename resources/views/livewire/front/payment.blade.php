<div class="container mx-auto min-h-screen p-4">
    <h1 class="mb-6 mt-20 text-center text-3xl font-bold">Pembayaran</h1>

    <div class="rounded-lg border p-4 shadow">
        <h2 class="mb-4 text-lg font-semibold">Rincian Pesanan</h2>
        <div class="space-y-4">
            <p><strong>Nama Lengkap:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}</p>
            <p><strong>Jenis Pengiriman:</strong> {{ $order->shipping_method }}</p>
            <p><strong>Total Pembayaran:</strong> Rp
                {{ number_format($order->price + $order->shipping_cost, 0, ',', '.') }}</p>
        </div>


        <div class="mt-6 text-center">
            @livewire('front.midtrans-payment', ['orderId' => $order->id])
        </div>

    </div>

</div>
