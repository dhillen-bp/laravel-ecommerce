<?php

namespace App\Livewire\Front;

use App\Models\Order;
use Livewire\Component;

class MidtransPayment extends Component
{
    public $orderId;


    public function render()
    {
        $order = Order::findOrFail($this->orderId);
        return view('livewire.front.midtrans-payment', ['order' => $order]);
    }
}
