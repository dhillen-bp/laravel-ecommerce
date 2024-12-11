<div>
    <section class="overflow-x-hidden">
        <div id="carousel-2" data-carousel='{ "loadingClasses": "opacity-0", "isAutoPlay": true, "speed": 5000 }'
            class="relative mt-9 max-h-96 w-full md:max-h-screen">
            <div class="carousel h-full rounded-none">
                <div class="carousel-body relative h-96 opacity-0 md:h-full">
                    <div class="carousel-slide">
                        <div class="flex h-full items-center justify-center">
                            <div class="absolute inset-0 bg-black opacity-80"></div>
                            <div class="absolute space-y-3 text-center">
                                <h2 class="text-3xl font-bold text-primary md:text-6xl">Selamat Datang</h2>
                                <p class="-mt-2 text-lg text-primary md:text-xl">Lihat dan kunjungi berbagai produk
                                    menarik
                                    pada toko
                                    kami.</p>
                                <a href="{{ route('front.products') }}" wire:navigate class="btn btn-primary mt-3">
                                    Lihat Produk Kami
                                </a>
                            </div>
                            <img src="{{ asset('images/hero-banner-1.svg') }}"
                                class="size-full max-h-[90vh] object-cover" alt="game" />
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <div class="flex h-full items-center justify-center">
                            <div class="absolute space-y-3 text-center">
                                <h2 class="text-3xl font-bold text-primary md:text-6xl">Tentang Kami</h2>
                                <p class="-mt-2 text-lg text-primary md:text-xl">Ingin tahu tentang toko kami? Dan cari
                                    tahu layanan apa saja yang kami berikan.</p>
                                <a href="{{ route('front.about') }}" wire:navigate class="btn btn-primary mt-3">
                                    Lihat Tentang Kami
                                </a>
                            </div>
                            <img src="{{ asset('images/hero-banner-2.svg') }}"
                                class="size-full max-h-[90vh] object-cover" alt="game" />
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <div class="flex h-full items-center justify-center">
                            <div class="absolute space-y-3 text-center">
                                <h2 class="text-3xl font-bold text-primary md:text-6xl">Laravel Olsop</h2>
                                <p class="-mt-2 text-lg text-primary md:text-xl">Laravel Olsop adalah ecommerce dengan
                                    produk tersedia dari berbagai kebutuhan pengguna.</p>
                            </div>
                            <img src="{{ asset('images/hero-banner-3.svg') }}"
                                class="size-full max-h-[90vh] object-cover" alt="game" />
                        </div>
                    </div>
                </div>
                <div class="carousel-pagination">
                    <span class="carousel-dot carousel-active:border-primary carousel-active:bg-primary"></span>
                    <span class="carousel-dot carousel-active:border-primary carousel-active:bg-primary"></span>
                    <span class="carousel-dot carousel-active:border-primary carousel-active:bg-primary"></span>
                </div>
            </div>
            <button type="button" class="carousel-prev">
                <span class="size-9.5 flex items-center justify-center rounded-full bg-base-100 shadow">
                    <span class="size-5 icon-[tabler--chevron-left] cursor-pointer rtl:rotate-180"></span>
                </span>
                <span class="sr-only">Previous</span>
            </button>
            <button type="button" class="carousel-next">
                <span class="sr-only">Next</span>
                <span class="size-9.5 flex items-center justify-center rounded-full bg-base-100 shadow">
                    <span class="size-5 icon-[tabler--chevron-right] cursor-pointer rtl:rotate-180"></span>
                </span>
            </button>
        </div>
    </section>

    <section class="mt-10 md:px-16">
        @livewire('components.list-category')

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
                    <div class="mb-4 mt-2 flex items-center justify-between gap-6">
                        <a href="{{ route('front.products.show', $product) }}" class="btn btn-info" wire:navigate><span
                                class="icon-[tabler--info-square] h-5"></span> <span
                                class="hidden text-sm lg:block">Lihat
                                Detail</span></a>

                        @livewire('components.button-buy-now', ['productId' => $product->id])
                    </div>
                    @livewire('front.cart.add-to-cart', ['productId' => $product->id])

                </div>
            @endforeach
        </div>
    </section>

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
