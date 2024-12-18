<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ButtonBuyNow extends Component
{
    public $productVariantId;

    public function mount($productVariantId)
    {
        $this->productVariantId = $productVariantId;
    }

    public function checkoutNow()
    {
        session()->put('checkoutItems', [strval($this->productVariantId)]);

        return $this->redirectRoute('front.checkout_now', navigate: true);
    }

    public function render()
    {
        return view('livewire.components.button-buy-now');
    }
}
