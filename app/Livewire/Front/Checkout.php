<?php

namespace App\Livewire\Front;

use Livewire\Attributes\Title;
use Livewire\Component;

class Checkout extends Component
{
    #[Title('Checkout')]
    public function render()
    {
        return view('livewire.front.checkout');
    }
}
