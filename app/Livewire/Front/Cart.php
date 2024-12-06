<?php

namespace App\Livewire\Front;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart')]
class Cart extends Component
{
    public function render()
    {
        return view('livewire.front.cart');
    }
}
