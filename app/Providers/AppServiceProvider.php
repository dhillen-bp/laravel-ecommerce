<?php

namespace App\Providers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Observers\CartItemObserver;
use App\Observers\ProductObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
        CartItem::observe(CartItemObserver::class);
        User::observe(UserObserver::class);
    }
}
