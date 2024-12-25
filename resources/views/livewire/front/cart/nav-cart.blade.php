<div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
    <button id="dropdown-scrollable" type="button"
        class="dropdown-toggle btn btn-circle btn-text size-10 dropdown-open:bg-base-content/10" aria-haspopup="menu"
        aria-expanded="false" aria-label="Dropdown">
        <div class="indicator">
            <span class="badge indicator-item badge-warning size-4 rounded-full p-0">
                <span class="text-sm">{{ count($cartItems) }}</span>
            </span>

            <span class="icon-[tabler--shopping-cart] size-[1.375rem] text-base-content"></span>
        </div>
    </button>
    <div class="dropdown-menu hidden dropdown-open:opacity-100" role="menu" aria-orientation="vertical"
        aria-labelledby="dropdown-scrollable">
        <div class="dropdown-header justify-center">
            <h6 class="text-base text-base-content/90">My Cart</h6>
        </div>
        <div
            class="horizontal-scroll vertical-scrollbar rounded-scrollbar max-h-56 w-full overflow-auto text-base-content/80 max-sm:max-w-80">
            @foreach ($cartItems as $item)
                <div class="dropdown-item flex w-full items-center" onclick="event.stopPropagation()">
                    <label class="flex w-full cursor-pointer gap-2 border-b border-gray-200 px-2 py-4">
                        <input type="checkbox" wire:model="selectedItems" value="{{ $item->id }}" class="mr-2">

                        <div class="avatar rounded-none">
                            <div class="w-10 md:w-14">
                                <img src="{{ $item->product_variant->image ? Storage::url($item->product_variant->image) : asset('images/laravel.svg') }}"
                                    alt="Product Image">
                            </div>
                        </div>
                        <div class="flex w-full items-start gap-8">
                            <div class="flex flex-col justify-between">
                                <h6 class="truncate text-sm font-semibold">{{ $item->product_variant->product->name }}
                                </h6>
                                <small class="text-sm">Variant: {{ $item->product_variant->variant->name }}</small>
                                <small class="text-sm text-gray-600">Qty: {{ $item->quantity }}</small>
                            </div>
                            <div class="flex w-full flex-col justify-between gap-2">
                                <span class="ml-0 text-sm font-semibold text-primary">Rp
                                    {{ number_format($item->product_variant->price * $item->quantity, 0, ',', '.') }}</span>
                                <button wire:click="removeFromCart({{ $item->id }})"
                                    class="btn btn-error btn-xs">Hapus</button>
                            </div>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>

        <!-- Total Price -->
        <div class="dropdown-footer justify-between px-4 py-2">
            <span class="text-sm font-semibold text-gray-800">Total:</span>
            <span class="text-sm font-semibold text-primary">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
        </div>

        <div class="dropdown-footer justify-between p-4">
            <button wire:click="checkoutSelected" class="btn btn-primary btn-sm w-full rounded-full">
                Checkout Sekarang
            </button>
        </div>

        <a href="{{ route('front.cart') }}" class="dropdown-footer justify-center gap-1">
            <span class="icon-[tabler--eye] size-4"></span> View all
        </a>
    </div>
</div>
