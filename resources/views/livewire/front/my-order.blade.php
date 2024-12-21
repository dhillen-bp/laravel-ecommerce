<div class="container mx-auto min-h-screen p-6">
    <h1 class="mb-6 mt-20 text-center text-3xl font-semibold">My Orders</h1>

    <div class="space-y-6">

        @foreach ($orders as $order)
            <div class="rounded-lg border bg-white p-4 shadow-md">
                <h2 class="text-xl font-semibold">Order Transaction:
                    {{ $order->payment ? $order->payment->transaction_id : 'Belum melakukan pembayaran' }}</h2>
                <p class="text-sm text-gray-600">Tanggal: {{ $order->created_at }}</p>
                <p class="text-sm text-gray-600">Kurir Pengiriman: {{ $order->shipping->courier_name }}</p>
                <p class="text-sm text-gray-600">Layanan Kurir:
                    {{ $order->shipping->courier_service . ' (' . $order->shipping->estimate_day . 'hari)' }}
                </p>
                <p class="text-sm text-gray-600">Biaya Pengiriman: {{ $order->shipping->cost }}</p>
                <div class="mt-2 space-y-2">
                    <p class="text-sm text-gray-600">Order Status: <livewire:components.order-status-badge
                            :status="$order->status" /></p>
                    <p class="text-sm text-gray-600">Payment Status:
                        <livewire:components.payment-status-badge :status="$order->payment ? $order->payment->status : 'Unpaid'" />
                    </p>
                </div>

                @foreach ($order->orderItems as $orderItem)
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="{{ $orderItem->productVariant->product->image ? Storage::url($orderItem->productVariant->product->image) : asset('images/laravel.svg') }}"
                                    alt="Product Image" class="mr-4 h-12 w-12 object-cover">
                                <span class="font-medium text-gray-700">{{ $orderItem->productVariant->product->name }}
                                    - {{ $orderItem->productVariant->variant->name }}</span>
                            </div>
                            <span class="text-sm text-gray-600">Rp
                                {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4 flex justify-between">
                    <a href="{{ route('front.order_detail', $order->id) }}" wire:navigate
                        class="btn btn-accent btn-text">View</a>
                    <span class="text-lg font-semibold">Total: Rp
                        {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach

    </div>
</div>
