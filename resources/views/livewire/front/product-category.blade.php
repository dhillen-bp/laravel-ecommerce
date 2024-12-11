<div class="min-h-screen px-6 py-8 md:px-12">

    <section class="mb-10 mt-20 text-center">
        @livewire('components.list-category')

        <h1 class="text-3xl font-bold">Semua Produk dengan Kategory</h1>
        <p class="mt-2 text-gray-500">Temukan berbagai produk terbaik kami.</p>
        <input wire:model.live.debounce.300ms="search" type="text"
            class="mt-2 w-full rounded-full border border-slate-500 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
            placeholder="Cari Produk..." aria-label="input" />
    </section>

    <section>
        <div wire:loading wire:target="search">
            <div class="flex items-center justify-center gap-2">
                <span class="loading loading-spinner loading-sm"></span>
                <span> Sedang mencari data... </span>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-6 sm:grid-cols-2 md:grid-cols-3 md:gap-10">
            @foreach ($products as $product)
                <div class="flex flex-col rounded-lg border p-4 shadow hover:shadow-lg"
                    wire:key="product-{{ $product->id }}">
                    <img src="{{ $product->image == null ? asset('images/laravel.svg') : Storage::url($product->image) }}"
                        alt="Produk" class="mb-4 w-full rounded-md object-cover md:h-56">
                    <span class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                        <h2 class="font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                    </span>
                    <p class="truncate text-sm text-gray-500">{{ $product->description }}</p>
                    <div class="flex justify-between">
                        <p>Stok: {{ $product->stock }}</p>
                        <span class="badge badge-primary badge-soft">{{ $product->category->name }}</span>
                    </div>
                    <div class="mb-4 mt-2 flex items-center justify-between gap-6">
                        <a href="{{ route('front.products.show', $product) }}" class="btn btn-info" wire:navigate><span
                                class="size-7 md:size-5 icon-[tabler--info-square]"></span> <span
                                class="hidden text-sm lg:block">Lihat
                                Detail</span></a>

                        @livewire('components.button-buy-now', ['productId' => $product->id], key('button-buy-now-' . $product->id))
                    </div>
                    @livewire('front.cart.add-to-cart', ['productId' => $product->id], key('add-to-cart-' . $product->id))
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->links('components.custom-pagination') }}
        </div>
    </section>
</div>
