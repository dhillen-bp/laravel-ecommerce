<div class="container mx-auto min-h-screen p-6">
    <h1 class="mb-6 mt-20 text-3xl font-semibold">Order Transaction:
        {{ $order->payment ? $order->payment->transaction_id : 'Pembayaran Gagal' }}</h1>

    <div class="rounded-lg border bg-white p-4 shadow-md">
        <h2 class="text-xl font-semibold">Products</h2>

        @foreach ($order->order_items as $orderItem)
            <div class="mt-4 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ $orderItem->product_variant->product->image ? Storage::url($orderItem->product_variant->product->image) : asset('images/laravel.svg') }}"
                            alt="Product Image" class="mr-4 h-12 w-12 object-cover">
                        <div>
                            <span class="font-medium text-gray-700">{{ $orderItem->product_variant->product->name }} -
                                {{ $orderItem->product_variant->variant->name }}</span>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-600">Quantity: {{ $orderItem->quantity }}</span>
                                <span class="text-sm text-gray-600">Harga satuan: Rp
                                    {{ number_format($orderItem->product_variant->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <span class="font-medium text-gray-700">Rp
                        {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach

        <div class="">
            <h3 class="mb-2 mt-6 text-xl font-semibold">Pengiriman</h3>
            <div>
                <p class="text-sm text-gray-600">Kurir Pengiriman: {{ $order->shipping->courier_name }}</p>
                <p class="text-sm text-gray-600">Layanan Kurir:
                    {{ $order->shipping->courier_service . ' (' . $order->shipping->estimate_day . 'hari)' }}
                </p>
                <p class="text-sm text-gray-600">Deskripsi Layanan: {{ $order->shipping->courier_service_description }}
                </p>
                <p class="text-sm text-gray-600">Alamat Pengiriman:
                    {{ $order->shipping->address . ', Kota: ' . $order->shipping->city->name . ', Provinsi: ' . $order->shipping->province->name }}
                </p>
            </div>
            <h3 class="mb-2 mt-6 text-xl font-semibold">Order Summary</h3>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-600">Status: <livewire:components.order-status-badge
                            :status="$order->status" /></p>
                    <p class="text-sm text-gray-600">Payment Status:
                        <livewire:components.payment-status-badge :status="$order->payment ? $order->payment->status : 'Unpaid'" />
                    </p>
                </div>
                <div class="flex flex-col items-end justify-end">
                    <p>Total item produk + Biaya Ongkir</p>
                    <p>{{ number_format($order->total_product_price, 0, ',', '.') . ' + ' . number_format($order->shipping->cost, 0, ',', '.') }}
                    </p>
                    <p class="text-base font-semibold text-gray-600">Total: Rp
                        {{ number_format($order->total_order_price, 0, ',', '.') }}</p>
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
