<?php

namespace App\Livewire\Front;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('About Us')]
class AboutUs extends Component
{
    public function render()
    {
        return view('livewire.front.about-us');
    }
}
