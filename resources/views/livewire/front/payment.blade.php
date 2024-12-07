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

        <form wire:submit.prevent='processPayment'>
            <div class="mt-6">
                <label for="payment_proof" class="mb-2 block font-semibold">Upload Bukti Pembayaran:</label>
                <input wire:model="payment_proof" type="file" id="payment_proof"
                    class="block w-full rounded-lg border p-2">
                @error('payment_proof')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="w-full rounded-lg bg-green-500 px-6 py-2 text-white hover:bg-green-600">
                    Bayar Sekarang
                </button>
            </div>
        </form>
    </div>

</div>
