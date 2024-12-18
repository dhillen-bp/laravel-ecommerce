<?php

namespace App\Livewire\Front;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Product')]
class ProductDetail extends Component
{
    public Product $product;
    public $selectedVariant;
    public $images;
    public $selectedImage;

    public function mount(Product $product)
    {
        $this->product = $product->load('variants');
        $this->selectedVariant = $this->product->variants->first();

        $this->images = collect([
            $this->product->image ? Storage::url($this->product->image) : null,
        ])->merge(
            $this->product->variants->pluck('image')->map(function ($image) {
                return $image ? Storage::url($image) : null;
            })
        )->filter()->values();

        $this->selectedImage = $this->images->first();
    }

    public function selectVariant($variantId)
    {
        $this->selectedVariant = $this->product->variants->find($variantId);

        $this->dispatch('variantSelected', $this->selectedVariant->pivot->id, $this->selectedVariant->pivot->stock);
    }

    public function updateMainImage($imageUrl)
    {
        $this->selectedImage = $imageUrl;

        $selectedVariant = $this->product->variants->first(function ($variant) use ($imageUrl) {
            return Storage::url($variant->image) === $imageUrl;
        });

        if ($selectedVariant) {
            $this->selectedVariant = $selectedVariant;
        } else {
            $this->selectedVariant = $this->product->variants->first();
        }
    }

    public function render()
    {
        $randomProducts = Product::with('category')
            ->where('is_active', 1)
            ->whereHas('variants', function ($query) {
                $query->where('stock', '>', 1);
            })
            ->where('slug', '!=', $this->product->slug)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('livewire.front.product-detail', [
            'product' => $this->product,
            'randomProducts' => $randomProducts
        ]);
    }
}
