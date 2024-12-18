<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        // Ambil data varian produk terkait
        $variants = $product->variants;

        return view('filament.resources.product-variants.index', compact('product', 'variants'));
    }
}
