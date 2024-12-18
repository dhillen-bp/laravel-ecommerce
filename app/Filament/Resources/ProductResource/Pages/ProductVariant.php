<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class ProductVariant extends Page
{
    protected static string $resource = ProductResource::class;

    protected static string $view = 'filament.resources.product-resource.pages.product-variant';
    public Product $product;

    protected function getTableQuery()
    {
        return $this->product->variants(); // Ambil varian dari produk
    }

    public function mount($product_id)
    {
        $this->product = Product::findOrFail($product_id);
    }
}
