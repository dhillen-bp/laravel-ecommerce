<div class="container mx-auto min-h-screen p-6">
    <h1 class="mb-6 mt-20 text-3xl font-semibold">Order Transaction: {{ $order->payment->transaction_id }}</h1>

    <div class="rounded-lg border bg-white p-4 shadow-md">
        <h2 class="text-xl font-semibold">Products</h2>

        @foreach ($order->orderItems as $orderItem)
            <div class="mt-4 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ $orderItem->product->image ? Storage::url($orderItem->product->image) : asset('images/laravel.svg') }}"
                            alt="Product Image" class="mr-4 h-12 w-12 object-cover">
                        <div>
                            <span class="font-medium text-gray-700">{{ $orderItem->product->name }}</span>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-600">Quantity: {{ $orderItem->quantity }}</span>
                                <span class="text-sm text-gray-600">Harga satuan: Rp
                                    {{ number_format($orderItem->product->price, 0, ',', '.') }}</span>
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
                    <p class="text-sm text-gray-600">Status: {{ $order->status }}</p>
                    <p class="text-sm text-gray-600">Payment Status: {{ $order->payment->status }}</p>
                </div>
                <p class="text-base font-semibold text-gray-600">Total: Rp
                    {{ number_format($order->price + $order->shipping_cost, 0, ',', '.') }}</p>
            </div>
        </div>


    </div>

    <div class="mt-6 flex flex-col rounded-lg border bg-white p-4 shadow-md">
        <h1 class="mb-6 text-3xl font-semibold">Bukti Pembayaran</h1>
        <span>Transaction ID : <span class="font-semibold">{{ $order->payment->transaction_id }}</span></span>
        <div>
            <span>Bukti Pembayaran:</span>
            <img src="{{ Storage::url($order->payment->payment_proof) }}" alt="" class="max-w-96">
        </div>
        <span>Status: <span class="font-semibold">{{ $order->payment->status }}</span></span>
        <span>Tanggal Transaksi: <span class="font-semibold">{{ $order->payment->created_at }}</span></span>
    </div>
</div>
