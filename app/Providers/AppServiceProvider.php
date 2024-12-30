<?php

namespace App\Providers;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use App\Observers\CartItemObserver;
use App\Observers\CategoryObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\ShippingObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\App;
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
        if (env('APP_ENV') === 'local') {
            URL::forceScheme('http');
        }
        URL::forceScheme('http');

        // Product::observe(ProductObserver::class);
        CartItem::observe(CartItemObserver::class);
        User::observe(UserObserver::class);
        Category::observe(CategoryObserver::class);
        Order::observe(OrderObserver::class);
        Shipping::observe(ShippingObserver::class);
    }
}
