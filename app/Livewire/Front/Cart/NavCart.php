<?php

namespace App\Livewire\Front\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class NavCart extends Component
{
    public $cartItems = [];
    public $cartTotal = 0;
    public $selectedItems = [];

    protected $listeners = ['cartUpdated' => 'loadCartItems'];

    public function mount()
    {
        $this->loadCartItems();
    }

    public function loadCartItems()
    {
        $userId = Auth::id();

        $cart = Cache::remember("cart_{$userId}", now()->addMinutes(10), function () use ($userId) {
            return Cart::where('user_id', $userId)->with('cart_items.productVariant.product', 'cart_items.productVariant.variant')->first();
        });

        if ($cart && $cart->cart_items) {
            $this->cartItems = $cart->cart_items;
            $this->cartTotal = $this->cartItems->sum(function ($item) {
                return $item->productVariant->price * $item->quantity;
            });
        } else {
            $this->cartItems = [];
            $this->cartTotal = 0;
        }
    }

    public function removeFromCart($cartItemId)
    {
        CartItem::find($cartItemId)->delete();
        Toaster::success('Produk berhasil dihapus dari keranjang!');
        $this->loadCartItems();
    }

    public function checkoutSelected()
    {
        if (empty($this->selectedItems)) {
            Toaster::error('Silakan pilih setidaknya satu item untuk checkout.');
            return;
        }

        session()->put('checkoutItems', $this->selectedItems);

        return $this->redirect(route('front.checkout'));
    }

    public function render()
    {
        return view('livewire.front.cart.nav-cart');
    }
}
