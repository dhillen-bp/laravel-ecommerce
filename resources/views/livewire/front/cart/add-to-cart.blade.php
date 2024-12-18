<div class="flex items-center justify-start space-x-4">
    <div class="flex items-center rounded-md border border-gray-300">
        <button id="decrease" class="px-2 py-1 text-gray-600 hover:bg-gray-200" wire:click="decreaseQuantity">-</button>
        <input id="quantity" type="number" min="1" max="{{ $stock ?? 1 }}" value="1" wire:model="quantity"
            class="border-b border-t border-gray-300 py-1.5 text-center text-sm focus:outline-none md:w-16">
        <button id="increase" class="px-2 py-1 text-gray-600 hover:bg-gray-200"
            wire:click="increaseQuantity">+</button>
    </div>
    <div>
        <button wire:click="addToCart" class="btn btn-primary">
            <span class="icon-[tabler--shopping-cart-plus] h-5"></span>
            <span class="hidden text-sm lg:block">Tambah ke Keranjang</span>
        </button>
    </div>
</div>
