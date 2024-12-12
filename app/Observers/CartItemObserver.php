<?php

namespace App\Observers;

use App\Models\CartItem;
use Illuminate\Support\Facades\Cache;

class CartItemObserver
{
    /**
     * Handle the CartItem "created" event.
     */
    public function created(CartItem $cartItem): void
    {
        Cache::forget("cart_" . $cartItem->cart->user_id);
    }

    /**
     * Handle the CartItem "updated" event.
     */
    public function updated(CartItem $cartItem): void
    {
        Cache::forget("cart_" . $cartItem->cart->user_id);
    }

    /**
     * Handle the CartItem "deleted" event.
     */
    public function deleted(CartItem $cartItem): void
    {
        Cache::forget("cart_" . $cartItem->cart->user_id);
    }

    /**
     * Handle the CartItem "restored" event.
     */
    public function restored(CartItem $cartItem): void
    {
        Cache::forget("cart_" . $cartItem->cart->user_id);
    }

    /**
     * Handle the CartItem "force deleted" event.
     */
    public function forceDeleted(CartItem $cartItem): void
    {
        Cache::forget("cart_" . $cartItem->cart->user_id);
    }
}
