<?php

namespace App\Livewire\Front;

use App\Models\CartItem;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Kavist\RajaOngkir\Facades\RajaOngkir;
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
    public $totalWeight;
    public $user;
    public $name;
    public $email;
    public $address;

    public $province_id;
    public $city_id;
    public $postal_code;
    public $provinces = [];
    public $cities = [];
    public $courier_name;
    public $courier_code;
    public $courier_service;
    public $courier_service_description;
    public $estimate_day;
    public $shipping_cost = 0;

    public $origin_province_id = 5;
    public $origin_city_id = 501;
    public $courierOptions = [];
    public $selectedCourierOption = 0;

    protected function rules()
    {
        return [
            'address' => 'required|string',
            'courier_code' => 'required|string',
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;

        $this->province_id = $this->user->province_id;
        $this->city_id = $this->user->city_id;
        $this->address = $this->user->address;
        $this->provinces = Province::all();
        if ($this->province_id) {
            $this->cities = City::where('province_id', $this->province_id)->get();
        }

        $selectedItems = session()->get('checkoutItems', []);

        if (empty($selectedItems)) {
            Toaster::error('Keranjang checkout kosong. Silakan pilih produk untuk checkout.');
            return $this->redirect(route('front.cart'), navigate: true);
        }

        $this->cartItems = CartItem::whereIn('id', $selectedItems)
            ->with('productVariant.product', 'productVariant.variant')
            ->get();

        $this->totalWeight = $this->cartItems->sum(function ($item) {
            return $item->productVariant->weight * $item->quantity;
        });

        $this->totalProductPrice = $this->cartItems->sum(function ($item) {
            return $item->productVariant->price * $item->quantity;
        });

        $this->totalProductPrice = $this->totalProductPrice;

        $this->totalPrice = $this->totalProductPrice;

        // $this->updateShippingCost();
    }

    public function fetchCities()
    {
        if ($this->province_id) {
            $this->cities = City::where('province_id', $this->province_id)->get();
        }
    }

    public function fetchShippingCost()
    {
        if ($this->courier_code && $this->city_id) {
            try {
                $origin = $this->origin_city_id;


                $response = RajaOngkir::ongkosKirim([
                    'origin' => $origin,
                    'destination' => $this->city_id,
                    'weight' => $this->totalWeight,
                    'courier' => $this->courier_code,
                ])->get();

                // dd($response[0]);

                if (isset($response[0]['costs'])) {
                    $this->courierOptions = $response[0]['costs'];
                    $this->shipping_cost = $this->courierOptions[$this->selectedCourierOption]['cost'][0]['value'];
                    $this->courier_name = $response[0]['name'];
                    $this->courier_code = $response[0]['code'];
                    $this->courier_service = $this->courierOptions[$this->selectedCourierOption]['service'];
                    $this->courier_service_description = $this->courierOptions[$this->selectedCourierOption]['description'];
                    $this->estimate_day = $this->courierOptions[$this->selectedCourierOption]['cost'][0]['etd'];
                } else {
                    $this->courierOptions = [];
                    Toaster::error('Tidak ada biaya pengiriman tersedia untuk opsi ini.');
                }

                $this->totalPrice = $this->totalProductPrice + $this->shipping_cost;
            } catch (\Exception $e) {
                Toaster::error('Terjadi kesalahan saat mengambil biaya pengiriman.');
                $this->shipping_cost = 0; // Set biaya ke 0 jika terjadi kesalahan
            }
        } else {
            $this->shipping_cost = 0; // Set biaya ke 0 jika provinsi atau kota belum dipilih
            Toaster::error('Pastikan telah mengisi provinsi, kota dan pilihan jasa kurir!');
        }
    }

    public function submitOrder()
    {
        DB::beginTransaction();
        try {
            $validated = $this->validate();

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_product_price' => $this->totalProductPrice,
                'total_price' => $this->totalProductPrice + $this->shipping_cost,
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

            $shipping = Shipping::create([
                'order_id' => $order->id,
                'province_id' => $this->province_id,
                'city_id' =>  $this->city_id,
                'address' => $this->address,
                'cost' => $this->shipping_cost,
                'courier_name' => $this->courier_name,
                'courier_code' => $this->courier_code,
                'courier_service' => $this->courier_service,
                'courier_service_description' => $this->courier_service_description,
                'estimate_day' => $this->estimate_day,
            ]);

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
