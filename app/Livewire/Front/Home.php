<?php

namespace App\Livewire\Front;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home')]
class Home extends Component
{
    public function render()
    {
        $products = Product::with('category', 'variants')
            ->where('is_active', 1)
            ->whereHas('variants', function ($query) {
                $query->where('stock', '>', 1);
            })
            ->take(3)
            ->get();

        return view('livewire.front.home', compact('products'));
    }
}
