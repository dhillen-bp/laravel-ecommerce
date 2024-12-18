<div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
    <button id="dropdown-scrollable" type="button"
        class="dropdown-toggle size-10 btn btn-circle btn-text dropdown-open:bg-base-content/10" aria-haspopup="menu"
        aria-expanded="false" aria-label="Dropdown">
        <div class="indicator">
            <span class="size-4 badge indicator-item badge-warning rounded-full p-0">
                <span class="text-sm">{{ count($cartItems) }}</span>
            </span>

            <span class="size-[1.375rem] icon-[tabler--shopping-cart] text-base-content"></span>
        </div>
    </button>
    <div class="dropdown-menu hidden dropdown-open:opacity-100" role="menu" aria-orientation="vertical"
        aria-labelledby="dropdown-scrollable">
        <div class="dropdown-header justify-center">
            <h6 class="text-base text-base-content/90">My Cart</h6>
        </div>
        <div
            class="horizontal-scroll max-sm:max-w-80 vertical-scrollbar rounded-scrollbar max-h-56 w-80 overflow-auto text-base-content/80">
            @foreach ($cartItems as $item)
                <label for="check-item-{{ $item->id }}"
                    class="dropdown-item flex gap-4 border-b border-gray-200 p-4">
                    <input type="checkbox" wire:model="selectedItems" value="{{ $item->id }}"
                        id="check-item-{{ $item->id }}">
                    <div class="avatar rounded-none">
                        <div class="w-14 rounded">
                            <img src="{{ $item->productVariant->image ? Storage::url($item->productVariant->image) : asset('images/laravel.svg') }}"
                                alt="Product Image">
                        </div>
                    </div>
                    <div class="flex items-start gap-8">
                        <div class="flex flex-col justify-between">
                            <h6 class="truncate text-sm font-semibold">{{ $item->productVariant->product->name }} </h6>
                            <small class="text-sm">Variant: {{ $item->productVariant->variant->name }}</small>
                            <small class="text-sm text-gray-600">Qty: {{ $item->quantity }}</small>
                        </div>
                        <div class="flex flex-col justify-between gap-2">
                            <span class="ml-0 text-sm font-semibold text-green-500">Rp
                                {{ number_format($item->productVariant->price * $item->quantity, 0, ',', '.') }}</span>
                            <button wire:click="removeFromCart({{ $item->id }})"
                                class="btn btn-error btn-xs">Hapus</button>
                        </div>
                    </div>
                </label>
            @endforeach

        </div>

        <!-- Total Price -->
        <div class="dropdown-footer justify-between px-4 py-2">
            <span class="text-sm font-semibold text-gray-800">Total:</span>
            <span class="text-sm font-semibold text-green-500">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
        </div>

        <div class="dropdown-footer justify-between p-4">
            <button wire:click="checkoutSelected" class="btn btn-success btn-sm w-full rounded-full">
                Checkout Sekarang
            </button>
        </div>

        <a href="{{ route('front.cart') }}" class="dropdown-footer justify-center gap-1">
            <span class="size-4 icon-[tabler--eye]"></span> View all
        </a>
    </div>
</div>
