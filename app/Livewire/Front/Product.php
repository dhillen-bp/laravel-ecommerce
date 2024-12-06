<?php

namespace App\Livewire\Front;

use App\Models\Product as ModelsProduct;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product')]
class Product extends Component
{
    public function render()
    {
        $products = ModelsProduct::where('is_active', 1)->where('stock', '>', 0)->paginate(9);
        return view('livewire.front.product', compact('products'));
    }
}
