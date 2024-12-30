<?php

namespace App\Observers;

use App\Models\Order;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $recipient = $order->user;
        $status = orderStatus($order->status);
        $statusClass = orderStatusClass($order->status);

        $recipient->notify(
            Notification::make()
                ->title('Pesanan Berhasil Dibuat')
                ->body("
                <div class='text-wrap max-w-96'>
                    <p class='font-bold '>Pesanan {$status}</p>
                    <p class='text-wrap'>Order ID: <span class='text-purple-500 block font-semibold text-wrap'>{$order->id}</span></p>
                    <p class='mb-2'>Order Status: <span class='$statusClass text-xs font-medium mr-2 px-2 py-1 rounded-full'>{$order->status}</span></p>
                    <a href='/my-order/$order->id' class='bg-primary text-white text-xs font-medium mt-2 px-2 py-1.5 rounded-full'>Lihat Detail</a>
                </div>
                ")
                ->toDatabase(),
        );
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
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
                    <p class='text-wrap'>Order ID: <span class='text-purple-500 block font-semibold text-wrap'>{$order->id}</span></p>
                    <p class='mb-2'>Order Status: <span class='$statusClass text-xs font-medium mr-2 px-2 py-1 rounded-full'>{$order->status}</span></p>
                    <a href='/my-order/$order->id' class='bg-primary text-white text-xs font-medium mt-2 px-2 py-1.5 rounded-full'>Lihat Detail</a>
                </div>
                ")
                ->toDatabase(),
        );
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
