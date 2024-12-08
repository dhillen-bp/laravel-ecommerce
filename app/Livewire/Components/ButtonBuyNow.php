<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ButtonBuyNow extends Component
{
    public $productId;

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function checkoutNow()
    {
        session()->put('checkoutItems', [strval($this->productId)]);

        return $this->redirect(route('front.checkout_now'));
    }

    public function render()
    {
        return view('livewire.components.button-buy-now');
    }
}
