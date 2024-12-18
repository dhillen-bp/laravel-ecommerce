<?php

namespace App\Livewire\Front;

use App\Models\Order;
use App\Models\Payment as ModelsPayment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

#[Title('Payment')]
class Payment extends Component
{
    public $order;
    public $user;
    public $transaction_id;
    public $status;
    public $total_price = 0;

    public function mount($order_id)
    {
        $this->order = Order::with('orderItems.productVariant.product', 'orderItems.productVariant.variant')->findOrFail($order_id);
        $this->user = Auth::user();

        if ($this->order->status !== 'pending') {
            Toaster::error('Pesanan ini tidak dapat diproses lebih lanjut.');
            return $this->redirect(route('front.order'), navigate: true);
        }
    }


    public function render()
    {
        return view('livewire.front.payment');
    }
}
