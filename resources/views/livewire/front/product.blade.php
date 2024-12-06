<div class="px-6 py-8 md:px-12">
    <!-- Header -->
    <section class="mb-10 mt-20 text-center">
        <h1 class="text-3xl font-bold">Semua Produk</h1>
        <p class="mt-2 text-gray-500">Temukan berbagai produk terbaik kami.</p>
    </section>

    <!-- Grid Produk -->
    <section>
        <div class="grid grid-cols-2 gap-6 px-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($products as $product)
                <div class="flex flex-col rounded-lg border p-4 shadow hover:shadow-lg">
                    <img src="{{ $product->image == null ? asset('images/laravel.svg') : Storage::url($product->image) }}"
                        alt="Produk" class="mb-4 w-full rounded-md object-cover md:h-56">
                    <span class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                        <h2 class="font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                    </span>
                    <p class="truncate text-sm text-gray-500">{{ $product->description }}</p>
                    <div class="mt-2 flex justify-around gap-6">
                        <a href="{{ route('front.products.show', $product) }}" class="btn btn-info" wire:navigate><span
                                class="icon-[tabler--info-square] h-5"></span> <span
                                class="hidden text-sm lg:block">Lihat
                                Detail</span></a>
                        <button class="btn btn-primary"><span class="icon-[tabler--shopping-cart-plus] h-5"></span>
                            <span class="hidden text-sm lg:block">Tambah ke Keranjang</span></button>
                    </div>
                    <button class="btn btn-success mt-3 self-center rounded md:text-base">
                        Beli Sekarang
                    </button>

                </div>
            @endforeach
        </div>
    </section>
</div>
