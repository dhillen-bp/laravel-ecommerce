<?php

namespace App\Livewire\Front;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Checkout')]
class Checkout extends Component
{
    #[Validate]

    public $cartItems = [];
    public $cartTotalPrice = 0;
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
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;

        $selectedItems = session()->get('checkoutItems', []);
        $this->cartItems = CartItem::whereIn('id', $selectedItems)
            ->with('product')
            ->get();

        if ($this->cartItems->isEmpty()) {
            Toaster::error('Keranjang checkout kosong. Silakan tambahkan produk.');
            return $this->redirect(route('front.cart'));
        }

        $selectedItems = session()->get('checkoutItems', []);
        $this->cartItems = CartItem::whereIn('id', $selectedItems)
            ->with('product')
            ->get();

        $this->cartTotalPrice = $this->cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

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
        $this->cartTotalPrice += $this->shipping_cost;
    }

    public function submitOrder()
    {
        try {
            $validated = $this->validate();

            // Jika validasi berhasil, lanjutkan pemesanan
            $order = Order::create([
                'user_id' => Auth::id(),
                'phone_number' => $this->phone_number,
                'price' => $this->cartTotalPrice -  $this->shipping_cost,
                'shipping_address' => $this->shipping_address,
                'shipping_method' => $this->shipping_method,
                'shipping_cost' => $this->shipping_cost,
            ]);

            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            session()->forget('checkoutItems');

            Toaster::success('Berhasil melakukan pemesanan!');

            return $this->redirect(route('front.payment', ['order_id' => $order->id]));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();

            foreach ($errors as $error) {
                Toaster::error($error);
            }

            return;
        }
    }

    public function render()
    {
        return view('livewire.front.checkout');
    }
}
