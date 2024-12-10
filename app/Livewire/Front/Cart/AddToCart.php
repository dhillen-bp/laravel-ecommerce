<?php

namespace App\Livewire\Front\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class AddToCart extends Component
{
    public $productId;
    public $quantity = 1;
    public $stock;

    public function mount($productId)
    {
        $this->productId = $productId;
        $product = cache()->remember("product_{$productId}", now()->addMinutes(30), function () use ($productId) {
            return Product::select('stock')->findOrFail($productId);
        });
        $this->stock = $product->stock;
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            Toaster::error('Anda harus login agar bisa menambahkan ke keranjang!');
            return $this->redirect(route('front.login'));
        }

        if ($this->quantity > $this->stock) {
            Toaster::error('Jumlah produk melebihi stok tersedia!');
            return;
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $this->productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $this->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $this->productId,
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
