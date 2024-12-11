<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        // Cache::forget('active_products');
        Cache::forget("product_{$product->id}");

        $this->forgetCachePages();
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Cache::forget('active_products');
        Cache::forget("product_{$product->id}");

        $this->forgetCachePages();
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        // Cache::forget('active_products');
        Cache::forget("product_{$product->id}");

        $this->forgetCachePages();
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }

    private function forgetCachePages()
    {
        $dataPerPage = 9;
        $totalPages = Product::where('is_active', 1)->where('stock', '>', 0)->count() / $dataPerPage;

        $totalPages = ceil($totalPages);

        for ($page = 1; $page <= $totalPages; $page++) {
            Cache::forget('active_products_page_' . $page);
        }
    }
}
