<?php

namespace App\Livewire\Front;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Checkout')]
class Checkout extends Component
{
    #[Validate]

    public $cartItems;
    public $totalPrice = 0;
    public $totalProductPrice = 0;
    public $user;
    public $name;
    public $email;
    public $phone_number;
    public $shipping_address;
    public $shipping_method;
    public $shipping_cost = 0;

    protected function rules()
    {
        return [
            // 'name' => 'required|string',
            // 'email' => 'required|email',
            'phone_number' => 'required|string',
            'shipping_address' => 'required|string',
            'shipping_method' => 'required|string',
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;

        $selectedItems = session()->get('checkoutItems', []);

        if (empty($selectedItems)) {
            Toaster::error('Keranjang checkout kosong. Silakan pilih produk untuk checkout.');
            return $this->redirect(route('front.cart'), navigate: true);
        }

        $this->cartItems = CartItem::whereIn('id', $selectedItems)
            ->with('productVariant.product', 'productVariant.variant')
            ->get();

        $this->totalProductPrice = $this->cartItems->sum(function ($item) {
            return $item->productVariant->price * $item->quantity;
        });

        $this->totalPrice = $this->totalProductPrice;

        $this->shipping_method = $this->shipping_method ?? 'standard';

        $this->updateShippingCost();
    }

    public function updateShippingCost()
    {

        if ($this->shipping_method == 'express') {
            $this->shipping_cost = 20000;
        } else {
            $this->shipping_cost = 5000;
        }
        $this->totalPrice = $this->totalProductPrice + $this->shipping_cost;
    }

    public function submitOrder()
    {
        DB::beginTransaction();
        try {
            $validated = $this->validate();

            $order = Order::create([
                'user_id' => Auth::id(),
                'phone_number' => $this->phone_number,
                'price' => $this->totalPrice -  $this->shipping_cost,
                'shipping_address' => $this->shipping_address,
                'shipping_method' => $this->shipping_method,
                'shipping_cost' => $this->shipping_cost,
            ]);

            foreach ($this->cartItems as $item) {
                $productVariant = $item->productVariant()->lockForUpdate()->first();

                if ($productVariant->stock < $item->quantity) {
                    DB::rollBack();
                    Toaster::error("Stok produk '{$productVariant->product->name}' tidak cukup.");
                    return;
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $productVariant->id,
                    'quantity' => $item->quantity,
                    'price' => $productVariant->price,
                ]);
            }

            $cart = $this->user->cart;
            if ($cart) {
                $cartItemIds = $this->cartItems->pluck('id')->toArray();

                $cart->cart_items()->whereIn('id', $cartItemIds)->delete();
            }

            session()->forget('checkoutItems');

            DB::commit();
            Toaster::success('Berhasil melakukan pemesanan!');
            Cache::forget("cart_" . $this->user->id);

            $this->dispatch('cartUpdated');

            return $this->redirect(route('front.payment', ['order_id' => $order->id]), navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            Toaster::error('Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.front.checkout');
    }
}
