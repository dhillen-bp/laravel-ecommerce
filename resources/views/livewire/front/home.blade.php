<div>
    <section class="overflow-x-hidden">
        <div id="carousel-2" data-carousel='{ "loadingClasses": "opacity-0", "isAutoPlay": true, "speed": 5000 }'
            class="relative mt-9 max-h-96 w-full md:max-h-screen">
            <div class="carousel h-full rounded-none">
                <div class="carousel-body relative h-96 opacity-0 md:h-full">
                    <!-- Slide 1 -->
                    <div class="carousel-slide">
                        <div class="flex h-full justify-center">
                            <img src="https://cdn.flyonui.com/fy-assets/components/carousel/image-22.png"
                                class="size-full object-cover" alt="game" />
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-slide">
                        <div class="flex h-full justify-center bg-base-300/80 p-6">
                            <span class="self-center text-2xl sm:text-4xl">Second slide</span>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="carousel-slide">
                        <div class="flex h-full justify-center bg-base-300 p-6">
                            <span class="self-center text-2xl sm:text-4xl">Third slide</span>
                        </div>
                    </div>
                </div>
                <div class="carousel-pagination">
                    <span class="carousel-dot carousel-active:border-primary carousel-active:bg-primary"></span>
                    <span class="carousel-dot carousel-active:border-primary carousel-active:bg-primary"></span>
                    <span class="carousel-dot carousel-active:border-primary carousel-active:bg-primary"></span>
                </div>
            </div>
            <!-- Previous Slide -->
            <button type="button" class="carousel-prev">
                <span class="size-9.5 flex items-center justify-center rounded-full bg-base-100 shadow">
                    <span class="size-5 icon-[tabler--chevron-left] cursor-pointer rtl:rotate-180"></span>
                </span>
                <span class="sr-only">Previous</span>
            </button>
            <!-- Next Slide -->
            <button type="button" class="carousel-next">
                <span class="sr-only">Next</span>
                <span class="size-9.5 flex items-center justify-center rounded-full bg-base-100 shadow">
                    <span class="size-5 icon-[tabler--chevron-right] cursor-pointer rtl:rotate-180"></span>
                </span>
            </button>
        </div>
    </section>

    <section class="mt-10 md:px-16">
        <h1 class="mb-6 text-center text-3xl font-bold">Produk Terbaru</h1>
        <div class="grid grid-cols-2 gap-6 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($products as $product)
                <div class="flex flex-col rounded-lg border p-4 shadow hover:shadow-lg">
                    <img src="{{ $product->image == null ? asset('images/laravel.svg') : Storage::url($product->image) }}"
                        alt="Produk 1" class="mb-4 w-full rounded-md object-cover md:h-56">
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

    <!-- Layanan Section -->
    <section class="mt-12 bg-gray-50 py-12 md:px-16">
        <h1 class="mb-6 text-center text-3xl font-bold">Layanan yang Kami Berikan</h1>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
            <!-- Layanan 1 -->
            <div class="rounded-lg border p-6 text-center shadow hover:shadow-lg">
                <span class="mb-4 block text-4xl">🚚</span>
                <h2 class="text-lg font-semibold">Pengiriman Cepat</h2>
                <p class="text-sm text-gray-500">Produk diantar dengan cepat dan aman ke tempat Anda.</p>
            </div>
            <!-- Layanan 2 -->
            <div class="rounded-lg border p-6 text-center shadow hover:shadow-lg">
                <span class="mb-4 block text-4xl">💳</span>
                <h2 class="text-lg font-semibold">Pembayaran Aman</h2>
                <p class="text-sm text-gray-500">Transaksi online yang mudah dan aman.</p>
            </div>
            <!-- Layanan 3 -->
            <div class="rounded-lg border p-6 text-center shadow hover:shadow-lg">
                <span class="mb-4 block text-4xl">📞</span>
                <h2 class="text-lg font-semibold">Layanan Pelanggan</h2>
                <p class="text-sm text-gray-500">Dukungan pelanggan 24/7 siap membantu Anda.</p>
            </div>
        </div>
    </section>
</div>
