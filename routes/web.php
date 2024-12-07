<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Masmerise\Toaster\Toaster;

Route::get('/', App\Livewire\Front\Home::class)->name('front.index');
Route::get('/products', App\Livewire\Front\Product::class)->name('front.products');
Route::get('/products/{product:slug}', App\Livewire\Front\ProductDetail::class)->name('front.products.show');
Route::get('/about-us', App\Livewire\Front\AboutUs::class)->name('front.about');
Route::get('/carts', App\Livewire\Front\Cart::class)->name('front.cart');
Route::get('/my-order', App\Livewire\Front\MyOrder::class)->name('front.order');
Route::get('/my-order/{order_id}', App\Livewire\Front\OrderDetail::class)->name('front.order_detail');
Route::get('/checkout', App\Livewire\Front\Checkout::class)->name('front.checkout');
Route::get('/payment/{order_id}', App\Livewire\Front\Payment::class)->name('front.payment');

Route::get('/login', App\Livewire\Auth\Login::class)->name('front.login');
Route::get('/register', App\Livewire\Auth\Register::class)->name('front.register');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    Toaster::success('Anda berhasil logout!');
    return redirect()->route('front.login');
})->name('front.logout');
