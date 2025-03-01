<?php

namespace App\Livewire\Front\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class AddToCart extends Component
{
    public $productVariantId;
    public $quantity = 1;
    public $stock;

    protected $listeners = ['variantSelected'];

    public function mount($productVariantId, $stock)
    {
        $this->productVariantId = $productVariantId;
        $this->stock = $stock;
    }

    // #[On('variantSelected')]
    public function variantSelected($productVariantId, $stock)
    {
        $this->productVariantId = $productVariantId;
        $this->stock = $stock;
        $this->quantity = 1; // Reset quantity to 1 when variant changes
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            Toaster::error('Anda harus login agar bisa menambahkan ke keranjang!');
            return $this->redirect(route('front.login'), navigate: true);
        }

        if (is_null(Auth::user()->email_verified_at)) {
            Toaster::error('Anda harus memverifikasi email terlebih dahulu!');
            return $this->redirect(route('verification.notice'), navigate: true);
            // return Redirect::route('verification.notice')
            //     ->error('The form contains several errors');
        }

        if (!Auth::user()->hasRole('customer')) {
            Toaster::error('Anda saat ini masuk sebagai Owner atau Admin. Silakan gunakan akun dengan peran Customer untuk melanjutkan proses.')->duration(5000);
            return;
        }

        if ($this->quantity > $this->stock) {
            Toaster::error('Jumlah pesanan melebihi stok tersedia!');
            return;
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $this->productVariantId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $this->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $this->productVariantId,
                'quantity' => $this->quantity,
            ]);
        }

        $this->dispatch('cartUpdated');
        Toaster::success('Produk berhasil ditambahkan ke keranjang!');
    }

    public function increaseQuantity()
    {
        if ($this->quantity < $this->stock) {
            $this->quantity++;
        }
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        return view('livewire.front.cart.add-to-cart');
    }
}
