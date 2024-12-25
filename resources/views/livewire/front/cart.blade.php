<div class="container mx-auto min-h-screen p-4">
    <h1 class="mb-6 mt-20 text-center text-3xl font-bold">Keranjang Belanja</h1>

    <div class="flex flex-col gap-4">
        @foreach ($cartItems as $item)
            <label for="item-{{ $item->id }}">
                <div class="flex items-center justify-between rounded-lg border p-4 shadow">
                    <div class="flex space-x-6">
                        <input type="checkbox" wire:model="selectedItems" value="{{ $item->id }}"
                            id="item-{{ $item->id }}">
                        <div class="flex items-start gap-4">
                            <img src="{{ $item->product_variant->product->image ? Storage::url($item->product_variant->product->image) : asset('images/laravel.svg') }}"
                                alt="Produk" class="h-24 w-24 rounded-md object-cover">
                            <div class="space-y-3">
                                <h2 class="text-lg font-semibold">{{ $item->product_variant->product->name }} -
                                    {{ $item->product_variant->variant->name }}</h2>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm">Quantity:</span>
                                    <div class="qty-container flex items-center rounded-md border border-gray-300">
                                        <input type="number" min="1" value="{{ $item->quantity }}"
                                            class="quantity-input w-12 border-b border-t border-gray-300 py-1 text-center text-sm focus:outline-none"
                                            data-id="{{ $item->id }}"
                                            wire:change="updateQuantity({{ $item->id }}, $event.target.value)" />
                                    </div>
                                </div>
                                <span class="text-sm">Harga satuan produk: <span>Rp
                                        {{ $item->product_variant->price }}</span></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-y-8">
                        <button wire:click="removeFromCart({{ $item->id }})"
                            class="btn btn-error btn-sm self-end rounded-full">Hapus</button>
                        <span class="self-end text-lg font-semibold">Rp
                            {{ number_format($item->product_variant->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                </div>
            </label>
        @endforeach
        <div class="mt-2 text-center">
            <a href="{{ route('front.products') }}" wire:navigate class="btn btn-primary btn-text">Lanjutkan
                Belanja</a>
        </div>
    </div>

    <div class="mt-6 flex justify-between rounded-lg border p-4 shadow">
        <div>
            <h2 class="text-lg font-semibold">Total</h2>
        </div>
        <div class="text-lg font-bold">Rp {{ number_format($cartTotalPrice, 0, ',', '.') }}</div>
    </div>

    <div class="mt-6 text-center">
        <button wire:click="checkoutSelected" class="btn btn-success w-full rounded-full">
            Checkout Sekarang
        </button>
    </div>
</div>
