<?php

namespace App\Observers;

use App\Models\Shipping;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ShippingObserver
{
    /**
     * Handle the Shipping "created" event.
     */
    public function created(Shipping $shipping): void
    {
        //
    }

    /**
     * Handle the Shipping "updated" event.
     */
    public function updated(Shipping $shipping): void
    {
        $order = $shipping->order;
        $recipient = $order->user;
        $status = orderStatus($order->status);
        $statusClass = orderStatusClass($order->status);
        Log::info("statusClass: " . $statusClass);

        $recipient->notify(
            Notification::make()
                ->title('Pesanan Berhasil Diperbarui')
                ->body("
                <div class='text-wrap max-w-96'>
                    <p class='font-bold '>Pesanan {$status}</p>
                    <p>Pesanan sedang dikirimkan!</p>
                    <p class='text-wrap'>Order ID: <span class='text-purple-500 font-semibold text-wrap'>{$order->id}</span></p>
                    <p>Order Status: <span class='$statusClass text-xs font-medium mr-2 px-2 py-1 rounded-full'>{$order->status}</span></p>
                    <p class='text-wrap'>Tracking mb-2 Number: <span class='text-purple-500 text-wrap'>{$shipping->tracking_number}</span></p>
                    <a href='/my-order/$order->id' class='bg-primary text-white text-xs font-medium px-2 py-1.5 rounded-full'>Lihat Detail</a>
                </div>
                ")
                ->toDatabase(),
        );
    }

    /**
     * Handle the Shipping "deleted" event.
     */
    public function deleted(Shipping $shipping): void
    {
        //
    }

    /**
     * Handle the Shipping "restored" event.
     */
    public function restored(Shipping $shipping): void
    {
        //
    }

    /**
     * Handle the Shipping "force deleted" event.
     */
    public function forceDeleted(Shipping $shipping): void
    {
        //
    }
}
