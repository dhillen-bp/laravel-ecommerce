<?php

namespace App\Livewire\Front;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product as ModelsProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Products')]
class Product extends Component
{
    public $currentProductId;

    public function mount($currentProductId)
    {
        $this->currentProductId = $currentProductId;
    }

    public function render()
    {
        $products = ModelsProduct::where('is_active', 1)->where('stock', '>', 0)->paginate(9);
        return view('livewire.front.product', compact('products'));
    }
}
