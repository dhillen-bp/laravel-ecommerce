<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Front\Home::class)->name('front.index');
Route::get('/products', App\Livewire\Front\Product::class)->name('front.products');
Route::get('/products/{product:slug}', App\Livewire\Front\ProductDetail::class)->name('front.products.show');
Route::get('/about-us', App\Livewire\Front\AboutUs::class)->name('front.about');
Route::get('/carts', App\Livewire\Front\Cart::class)->name('front.cart');
Route::get('/checkout', App\Livewire\Front\Checkout::class)->name('front.checkout');
