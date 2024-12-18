<div class="mx-auto max-w-7xl p-6 lg:p-8">
    <!-- Product Detail Section -->
    <div class="mb-6 mt-20 grid grid-cols-1 gap-8 md:grid-cols-2">
        <div class="flex flex-col items-center">
            <!-- Main Image -->
            <img src="{{ $selectedImage }}" alt="Product Image" id="main-image"
                class="h-96 w-full rounded-lg object-cover shadow-lg">
            <!-- Thumbnail Slider -->
            <div class="swiper-container mt-6 w-full">
                <div class="swiper-wrapper flex items-center justify-center gap-3">
                    <div class="swiper-button-next">
                        <span class="size-7 md:size-5 icon-[tabler--caret-left]"></span>
                    </div>
                    @foreach ($images as $image)
                        <div class="swiper-slide">
                            <img src="{{ $image }}" alt="Product Image"
                                wire:click="updateMainImage('{{ $image }}')"
                                class="{{ $selectedImage == $image ? 'border border-primary' : '' }} h-20 w-20 cursor-pointer rounded-lg border border-gray-300 object-cover hover:border-blue-500">
                        </div>
                    @endforeach
                    <div class="swiper-button-prev">
                        <span class="size-7 md:size-5 icon-[tabler--caret-right]"></span>
                    </div>
                </div>

            </div>

        </div>

        <!-- Product Details -->
        <div class="space-y-6">
            <h1 class="text-3xl font-semibold text-gray-800">{{ $product->name }}</h1>
            <p class="text-2xl font-bold text-gray-900">
                Rp. {{ number_format($selectedVariant->pivot->price, 0, ',', '.') }}
            </p>

            <p class="text-gray-600">
                {{ $product->description }}
            </p>
            <div class="space-y-4">
                <h2 class="text-lg font-semibold">Varian (Nama & Stok):</h2>
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($product->variants as $variant)
                        <label
                            class="{{ $selectedVariant['id'] === $variant->id ? 'border-blue-500' : '' }} flex cursor-pointer items-center justify-between rounded border p-2">
                            <input type="radio" wire:click="selectVariant({{ $variant->id }})" class="hidden"
                                {{ $selectedVariant['id'] === $variant->id ? 'checked' : '' }}>
                            <span>{{ $variant->name }}</span>
                            <span>Stok: {{ $variant->pivot->stock }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            @livewire('front.cart.add-to-cart', ['productVariantId' => $selectedVariant->pivot->id, 'stock' => $selectedVariant->pivot->stock])
            @livewire('components.button-buy-now', ['productVariantId' => $selectedVariant->pivot->id])

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
                    <img src="{{ $random->image != null ? formatImageUrl($random->image) : asset('images/laravel.svg') }}"
                        class="mb-4 h-48 w-full rounded-lg object-cover" alt="Product">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $random->name }}</h3>
                    <p class="text-gray-600">Rp.
                        {{ number_format($random->variants->first()->pivot->price, 0, ',', '.') }}
                    </p>

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

@push('after-script')
    <script>
        // Swiper Initialization
        // const swiper = new Swiper('.swiper-container', {
        //     slidesPerView: 4,
        //     spaceBetween: 10,
        //     navigation: {
        //         nextEl: '.swiper-button-next',
        //         prevEl: '.swiper-button-prev',
        //     },

        // });
    </script>
@endpush
