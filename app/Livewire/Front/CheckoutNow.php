<?php

namespace App\Livewire\Front;

use App\Models\City;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Province;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toast;
use Masmerise\Toaster\Toaster;

#[Title('Checkout')]
class CheckoutNow extends Component
{
    #[Validate]

    // public $product;
    public $selectedVariant;

    public $totalOrderPrice = 0;
    public $totalProductPrice = 0;
    public $originalTotalProductPrice;
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

    public $voucher = [
        'code' => '',
        'percentage' => 0,
        'amount' => 0,
        'error' => null,
    ];

    protected function rules()
    {
        return [
            // 'name' => 'required|string',
            // 'email' => 'required|email',
            // 'phone_number' => 'required|string',
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

        // $this->product = Product::whereIn('id', $selectedItems)
        //     ->first();
        $this->selectedVariant = ProductVariant::with('product', 'variant')->whereIn('id', $selectedItems)->first();
        if (!$this->selectedVariant) {
            Toaster::error('Varian produk yang dipilih tidak ditemukan.');
            return $this->redirect(route('front.cart'), navigate: true);
        }

        $this->totalProductPrice = $this->selectedVariant->price;

        $this->totalOrderPrice = $this->totalProductPrice;
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
                $weight = $this->selectedVariant->weight;

                $response = RajaOngkir::ongkosKirim([
                    'origin' => $origin,
                    'destination' => $this->city_id,
                    'weight' => $weight,
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

                $this->totalOrderPrice = $this->totalProductPrice + $this->shipping_cost;
            } catch (\Exception $e) {
                Toaster::error('Terjadi kesalahan saat mengambil biaya pengiriman.');
                $this->shipping_cost = 0;
            }
        } else {
            $this->shipping_cost = 0;
            Toaster::error('Pastikan telah mengisi provinsi, kota dan pilihan jasa kurir!');
        }
    }

    public function applyVoucher()
    {
        $this->voucher['error'] = null; // Reset error
        $voucher = Discount::where('code', $this->voucher['code'])->first();
        $originalTotalProductPrice = $this->totalProductPrice;

        if (!$voucher || $voucher->start_date > now()) {
            $this->voucher['error'] = 'Kode voucher tidak valid.';
            $this->voucher['code'] = null;
            return;
        }

        if ($this->voucher['amount'] > 0) {
            // $this->voucher['error'] = 'Voucher sudah diterapkan.';
            Toaster::error('Voucher sudah diterapkan!');
            $this->voucher['code'] = null;
            return;
        }

        if ($voucher->end_date < now()) {
            $this->voucher['error'] = 'Kode voucher sudah kadaluarsa.';
            $this->voucher['code'] = null;
            return;
        }

        $userId = Auth::id();
        $usedCount = Order::where('user_id', $userId)
            ->where('discount_code', $this->voucher['code'])
            ->count();

        if ($usedCount >= 1) {
            $this->voucher['error'] = 'Anda sudah menggunakan kode voucher ini.';
            $this->voucher['code'] = null;
            return;
        }

        if ($voucher->type === 'fixed') {
            $this->voucher['amount'] = $voucher->amount;
            $this->totalProductPrice = max(0, $this->totalProductPrice - $this->voucher['amount']);
        } else {
            $this->voucher['percentage'] = $voucher->percentage;
            $this->voucher['amount'] = ($this->voucher['percentage'] / 100)  *  $this->totalProductPrice;
            $this->totalProductPrice = max(0, $this->totalProductPrice - $this->voucher['amount']);
        }

        $this->totalOrderPrice = $this->totalProductPrice + $this->shipping_cost;
    }


    public function submitOrder()
    {
        DB::beginTransaction();
        try {
            $validated = $this->validate();

            $order = Order::create([
                'user_id' => Auth::id(),
                'discount_code' => $this->voucher['code'],
                'discount_amount' => $this->voucher['amount'],
                'total_product_price' => $this->totalProductPrice,
                'total_order_price' => $this->totalOrderPrice,
            ]);

            $product_variant = ProductVariant::lockForUpdate()->find($this->selectedVariant->id);
            if ($product_variant->stock <= 0) {
                Toaster::error('Stok produk yang dipilih habis.');
                return;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $this->selectedVariant->id,
                'quantity' => 1,
                'price' => $this->selectedVariant->price,
            ]);

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

            if (!empty($this->voucher['code'])) {
                $discount = Discount::where('code', $this->voucher['code'])->first();
                if ($discount) {

                    if ($discount->claimed < $discount->claim_limit) {
                        $discount->increment('claimed');
                    } else {
                        Toaster::error('Kode voucher sudah mencapai batas klaim.');
                        DB::rollBack();
                        return;
                    }
                }
            }

            session()->forget('checkoutItems');

            $this->dispatch('cartUpdated');

            DB::commit();
            Toaster::success('Berhasil melakukan pemesanan!');

            return $this->redirectRoute('front.payment', ['order_id' => $order->id], navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Pesan: " . $e);
            Toaster::error('Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.front.checkout-now');
    }
}
