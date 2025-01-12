<?php

namespace App\Livewire\Components;

use App\Models\Review;
use Livewire\Component;

class ListReview extends Component
{
    public $productId;

    protected $listeners = ['refreshReviews' => 'loadReviews'];

    public $reviews;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->loadReviews();
    }

    public function loadReviews()
    {
        $this->reviews = Review::where('product_id', $this->productId)
            ->with(['user', 'files'])
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.components.list-review');
    }
}
