<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ButtonBuyNow extends Component
{
    public $productVariantId;

    public function mount($productVariantId)
    {
        $this->productVariantId = $productVariantId;
    }

    public function checkoutNow()
    {
        if (!Auth::check()) {
            Toaster::error('Anda harus login agar bisa menambahkan ke keranjang!');
            return $this->redirect(route('front.login'), navigate: true);
        }

        if (is_null(Auth::user()->email_verified_at)) {
            Toaster::error('Anda harus memverifikasi email terlebih dahulu!');
            return $this->redirect(route('verification.notice'), navigate: true);
        }

        session()->put('checkoutItems', [strval($this->productVariantId)]);

        return $this->redirectRoute('front.checkout_now', navigate: true);
    }

    public function render()
    {
        return view('livewire.components.button-buy-now');
    }
}
