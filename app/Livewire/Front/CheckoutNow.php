<?php

namespace App\Livewire\Front;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Checkout')]
class CheckoutNow extends Component
{
    #[Validate]

    // public $product;
    public $selectedVariant;

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

        // $this->product = Product::whereIn('id', $selectedItems)
        //     ->first();
        $this->selectedVariant = ProductVariant::with('product', 'variant')->whereIn('id', $selectedItems)->first();
        if (!$this->selectedVariant) {
            Toaster::error('Varian produk yang dipilih tidak ditemukan.');
            return $this->redirect(route('front.cart'), navigate: true);
        }

        $this->totalProductPrice = $this->selectedVariant->price;

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
                'price' => $this->totalProductPrice,
                'shipping_address' => $this->shipping_address,
                'shipping_method' => $this->shipping_method,
                'shipping_cost' => $this->shipping_cost,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $this->selectedVariant->id,
                'quantity' => 1,
                'price' => $this->selectedVariant->price,
            ]);

            session()->forget('checkoutItems');

            $this->dispatch('cartUpdated');

            DB::commit();
            Toaster::success('Berhasil melakukan pemesanan!');

            return $this->redirectRoute('front.payment', ['order_id' => $order->id], navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            Toaster::error('Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.front.checkout-now');
    }
}
