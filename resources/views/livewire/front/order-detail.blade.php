<div class="container mx-auto min-h-screen p-6">
    <h1 class="mb-6 mt-20 text-3xl font-semibold">Order Transaction:
        {{ $order->payment ? $order->payment->transaction_id : 'Pembayaran Gagal' }}</h1>

    <div class="rounded-lg border bg-white p-4 shadow-md">
        <h2 class="text-xl font-semibold">Products</h2>

        @foreach ($order->orderItems as $orderItem)
            <div class="mt-4 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ $orderItem->productVariant->product->image ? Storage::url($orderItem->productVariant->product->image) : asset('images/laravel.svg') }}"
                            alt="Product Image" class="mr-4 h-12 w-12 object-cover">
                        <div>
                            <span class="font-medium text-gray-700">{{ $orderItem->productVariant->product->name }} -
                                {{ $orderItem->productVariant->variant->name }}</span>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-600">Quantity: {{ $orderItem->quantity }}</span>
                                <span class="text-sm text-gray-600">Harga satuan: Rp
                                    {{ number_format($orderItem->productVariant->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <span class="font-medium text-gray-700">Rp
                        {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach

        <div class="mt-6">
            <h3 class="text-xl font-semibold">Order Summary</h3>
            <div class="mt-4 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Status: <livewire:components.order-status-badge
                            :status="$order->status" /></p>
                    <p class="text-sm text-gray-600">Payment Status:
                        <livewire:components.payment-status-badge :status="$order->payment ? $order->payment->status : 'Unpaid'" />
                    </p>
                </div>
                <div class="flex flex-col items-end justify-end">
                    <p>Total item produk + Biaya Ongkir</p>
                    <p>{{ number_format($order->price, 0, ',', '.') . ' + ' . number_format($order->shipping_cost, 0, ',', '.') }}
                    </p>
                    <p class="text-base font-semibold text-gray-600">Total: Rp
                        {{ number_format($order->price + $order->shipping_cost, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex flex-col rounded-lg border bg-white p-4 shadow-md">
        <h1 class="mb-6 text-3xl font-semibold">Detail Pembayaran</h1>
        @if ($order->payment)
            <span>Transaction ID : <span class="font-semibold">{{ $order->payment->transaction_id }}</span></span>
            <span>Payment Status: <span class="font-semibold">{{ $order->payment->status }}</span></span>
            <span>Midtrans Status: <span class="font-semibold">{{ $order->payment->midtrans_status }}</span></span>
            <span>Payment Type: <span class="font-semibold">{{ $order->payment->payment_type }}</span></span>
            <span>Bank: <span class="font-semibold">{{ $order->payment->bank }}</span></span>
            <span>Tanggal Transaksi: <span class="font-semibold">{{ $order->payment->created_at }}</span></span>
        @else
            <div class="space-y-2">
                <p class="text-xl font-semibold"><span class="text-error">Pembayaran Gagal</span>: Pembayaran Anda tidak
                    berhasil diproses.</p>
                <a href="{{ route('front.products') }}" wire:navigate~ class="btn btn-primary w-full">Tekan disini
                    untuk
                    melihat semua produk kami</a>
            </div>
        @endif

    </div>
</div>
