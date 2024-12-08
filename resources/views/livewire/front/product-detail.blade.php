<div class="mx-auto max-w-7xl p-6 lg:p-8">
    <!-- Product Detail Section -->
    <div class="mb-6 mt-20 grid grid-cols-1 gap-8 md:grid-cols-2">
        <div class="flex justify-center">
            <img src="{{ $product->image != null ? Storage::url($product->image) : asset('images/laravel.svg') }}"
                alt="Product Image" class="max-h-[500px] w-full rounded-lg object-cover shadow-lg md:h-auto md:w-full">
        </div>

        <div class="space-y-6">
            <h1 class="text-3xl font-semibold text-gray-800">{{ $product->name }}</h1>

            <p class="text-2xl font-bold text-gray-900">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>

            <p class="text-gray-600">
                {{ $product->description }}
            </p>

            <div class="space-y-2">
                <div class="flex items-center">
                    <span class="font-semibold text-gray-700">Stok:</span>
                    <span class="ml-2 text-gray-600">{{ $product->stock }}</span>
                </div>
            </div>

            @livewire('front.cart.add-to-cart', ['productId' => $product->id])
            @livewire('components.button-buy-now', ['productId' => $product->id])

            <div class="flex items-center space-x-2">
                <span class="text-yellow-500">⭐⭐⭐⭐⭐</span>
                <span class="text-gray-600">(100 Ulasan)</span>
            </div>
        </div>
    </div>

    <section class="mt-12">
        <h2 class="text-2xl font-semibold text-gray-800">Produk Terkait</h2>
        <div class="mt-4 grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($randomProducts as $random)
                <div class="rounded-lg border p-4">
                    <img src="{{ $random->image != null ? Storage::url($random->image) : asset('images/laravel.svg') }}"
                        class="mb-4 h-48 w-full rounded-lg object-cover" alt="Product">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $random->name }}</h3>
                    <p class="text-gray-600">Rp. {{ number_format($random->price, 0, ',', '.') }}</p>

                    <div class="mb-4 mt-2 flex items-center justify-between gap-6">
                        <a href="{{ route('front.products.show', $random) }}" class="btn btn-info" wire:navigate><span
                                class="icon-[tabler--info-square] h-5"></span> <span
                                class="hidden text-sm lg:block">Lihat
                                Detail</span></a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-12 border-t pt-6">
        <h2 class="text-2xl font-semibold text-gray-800">Informasi Pengiriman & Garansi</h2>
        <p class="text-gray-600">Pengiriman standar perlu biaya tambahan Rp. 5.000. Pengirman express perlu biaya
            tambahan Rp. 20.000.</p>
    </section>
</div>
