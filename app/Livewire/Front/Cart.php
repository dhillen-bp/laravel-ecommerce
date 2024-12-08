<?php

namespace App\Livewire\Front;

use App\Models\Cart as ModelsCart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Cart')]
class Cart extends Component
{
    public $cartItems = [];
    public $cartTotalPrice = 0;
    public $selectedItems = [];

    public function mount()
    {
        $this->loadCartItems();
    }

    public function loadCartItems()
    {
        $cart = ModelsCart::where('user_id', Auth::id())->first();

        if ($cart) {
            $this->cartItems = CartItem::where('cart_id', $cart->id)
                ->with('product')
                ->get();

            $this->cartTotalPrice = $this->cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
        }
    }

    public function removeFromCart($cartItemId)
    {
        CartItem::find($cartItemId)->delete();
        Toaster::success('Produk berhasil dihapus dari keranjang!');
        $this->loadCartItems();

        $this->dispatch('cartUpdated');
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $cartItem = CartItem::find($cartItemId);

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();

            $this->loadCartItems();
        }

        $this->dispatch('cartUpdated');
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
        return view('livewire.front.cart');
    }
}
