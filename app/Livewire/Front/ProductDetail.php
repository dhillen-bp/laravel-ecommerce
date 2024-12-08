<?php

namespace App\Livewire\Front;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Product')]
class ProductDetail extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        $randomProducts = Product::where('id', '!=', $this->product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('livewire.front.product-detail', [
            'product' => $this->product,
            'randomProducts' => $randomProducts
        ]);
    }
}
