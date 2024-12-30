<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Masmerise\Toaster\Toaster;

Route::post('/logout', App\Livewire\Auth\LogoutButton::class)->middleware('auth')->name('front.logout');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', App\Livewire\Auth\Login::class)->name('front.login');
    Route::get('/register', App\Livewire\Auth\Register::class)->name('front.register');

    Route::get('/forgot-password', App\Livewire\Auth\ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', App\Livewire\Auth\ResetPassword::class)->name('password.reset');
});

Route::get('/', App\Livewire\Front\Home::class)->name('front.index');
Route::get('/about-us', App\Livewire\Front\AboutUs::class)->name('front.about');
Route::get('/products', App\Livewire\Front\Product::class)->name('front.products');
Route::get('/products/{product:slug}', App\Livewire\Front\ProductDetail::class)->name('front.products.show');
Route::get('/products/category/{category:slug}', App\Livewire\Front\ProductCategory::class)->name('front.products.category');

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/email/verify', App\Livewire\Auth\VerifyEmail::class)->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/my-profile');
    })->middleware(['auth', 'signed'])->name('verification.verify');
    // Route::post('/email/verification-notification', function (Request $request) {
    //     $request->user()->sendEmailVerificationNotification();
    //     return back()->with('message', 'Verification link sent!');
    // })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    Route::get('/my-profile', App\Livewire\Front\MyProfile::class)->name('front.my_profile');

    Route::middleware(['verified'])->group(function () {
        Route::get('/notifications', App\Livewire\Front\Notification::class)->name('front.notification');
        Route::get('/carts', App\Livewire\Front\Cart::class)->name('front.cart');
        Route::get('/my-order', App\Livewire\Front\MyOrder::class)->name('front.order');
        Route::get('/my-order/{order_id}', App\Livewire\Front\OrderDetail::class)->name('front.order_detail');
        Route::get('/checkout', App\Livewire\Front\Checkout::class)->name('front.checkout');
        Route::get('/checkout-now', App\Livewire\Front\CheckoutNow::class)->name('front.checkout_now');
        Route::get('/payment/{order_id}', App\Livewire\Front\Payment::class)->name('front.payment');

        Route::post('/payment/create', [PaymentController::class, 'createPayment']);
        Route::post('/payment-failed/{order}', [PaymentController::class, 'paymentFailed']);
        Route::get('/payment-failed', [PaymentController::class, 'paymentFailedMessage']);
    });
});
Route::post('/payment/callback', [PaymentController::class, 'paymentCallback']);

Route::middleware(['auth', 'role:owner'])->group(function () {
    // Route::get('products/{product}/variants', [ProductVariantController::class, 'index'])->name('products.variants');
});
