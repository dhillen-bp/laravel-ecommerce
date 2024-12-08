<?php

namespace App\Livewire\Front\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
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
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $this->cartItems = CartItem::where('cart_id', $cart->id)
                ->with('product') // Jika ingin memuat produk
                ->get();
            $this->cartTotal = $this->cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
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
