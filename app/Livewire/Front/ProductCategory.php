<?php

namespace App\Livewire\Front;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products Category')]
class ProductCategory extends Component
{
    use WithPagination;

    public $search = '';
    public $categorySlug;

    public function mount($category)
    {
        $this->categorySlug = $category;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $category = Category::select('id')->where('slug', $this->categorySlug)->first();
        $products = Product::with('category')
            ->where('is_active', 1)->where('category_id', $category->id)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->whereHas('variants', function ($query) {
                $query->where('stock', '>', 1);
            })
            ->latest()
            ->paginate(9);

        return view('livewire.front.product-category', compact('products'));
    }
}
