<?php

namespace App\Livewire\Front;

use App\Models\Product as ModelsProduct;
use App\Models\ProductVariant;
use App\Models\Variant;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products')]
class Product extends Component
{
    use WithPagination;

    public $search = '';
    public $sortPrice = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSortPrice()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = ModelsProduct::with(['category', 'variants'])
            ->where('is_active', 1)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->whereHas('variants', function ($query) {
                $query->where('stock', '>', 1);
            })
            ->when($this->sortPrice, function ($query) {
                $query->orderBy(
                    ProductVariant::select('price')
                        ->whereColumn('product_variants.product_id', 'products.id')
                        ->take(1),
                    $this->sortPrice === 'low_to_high' ? 'asc' : 'desc'
                );
            })
            ->latest()
            ->paginate(9);


        return view('livewire.front.product', [
            'products' => $products,
        ]);
    }
}
