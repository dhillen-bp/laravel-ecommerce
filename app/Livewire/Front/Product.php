<?php

namespace App\Livewire\Front;

use App\Models\Product as ModelsProduct;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products')]
class Product extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = ModelsProduct::with('category')->where('is_active', 1)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(9);

        return view('livewire.front.product', [
            'products' => $products,
        ]);
    }
}
