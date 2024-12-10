<div class="px-6 py-8 md:px-12">

    <!-- Header -->
    <section class="mb-10 mt-20 text-center">
        <h1 class="text-3xl font-bold">Semua Produk</h1>
        <p class="mt-2 text-gray-500">Temukan berbagai produk terbaik kami.</p>
    </section>

    <!-- Grid Produk -->
    <section>
        <div class="grid grid-cols-2 gap-6 px-4 sm:grid-cols-2 md:grid-cols-3 md:gap-10">
            @foreach ($products as $product)
                <div class="flex flex-col rounded-lg border p-4 shadow hover:shadow-lg">
                    <img src="{{ $product->image == null ? asset('images/laravel.svg') : Storage::url($product->image) }}"
                        alt="Produk" class="mb-4 w-full rounded-md object-cover md:h-56">
                    <span class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                        <h2 class="font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                    </span>
                    <p class="truncate text-sm text-gray-500">{{ $product->description }}</p>
                    <p>Stok: {{ $product->stock }}</p>
                    <div class="mb-4 mt-2 flex items-center justify-between gap-6">
                        <a href="{{ route('front.products.show', $product) }}" class="btn btn-info" wire:navigate><span
                                class="size-7 md:size-5 icon-[tabler--info-square]"></span> <span
                                class="hidden text-sm lg:block">Lihat
                                Detail</span></a>

                        @livewire('components.button-buy-now', ['productId' => $product->id])
                    </div>
                    @livewire('front.cart.add-to-cart', ['productId' => $product->id])
                </div>
            @endforeach
        </div>
    </section>
</div>
