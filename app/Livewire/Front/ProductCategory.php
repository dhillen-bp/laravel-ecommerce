<?php

namespace App\Livewire\Front;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products Category')]
class ProductCategory extends Component
{
    use WithPagination;

    public $search = '';
    public $sortPrice = '';
    public $categorySlug;

    public function mount($category)
    {
        $this->categorySlug = $category;
    }

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
        $category = Category::select('id')->where('slug', $this->categorySlug)->first();
        $products = Product::with(['category', 'variants'])
            ->where('is_active', 1)->where('category_id', $category->id)
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

        return view('livewire.front.product-category', compact('products'));
    }
}
