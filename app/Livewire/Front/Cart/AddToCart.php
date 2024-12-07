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

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            Toaster::error('Anda harus login agar bisa menambahkan ke keranjang!');
            return $this->redirect(route('front.login'));
        }


        $product = Product::findOrFail($this->productId);

        // Cek apakah pengguna memiliki keranjang
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // Tambahkan produk ke keranjang
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $this->productId)
            ->first();

        if ($cartItem) {
            // Jika produk sudah ada di keranjang, tambah jumlahnya
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Jika belum, tambahkan sebagai item baru
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $this->productId,
                'quantity' => 1,
            ]);
        }

        $this->dispatch('cartUpdated');
        Toaster::success('Produk berhasil ditambahkan ke keranjang!');
    }

    public function render()
    {
        return view('livewire.front.cart.add-to-cart');
    }
}
