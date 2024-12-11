<?php

namespace App\Livewire\Front;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Order Detail')]
class OrderDetail extends Component
{
    public $order;

    public function mount($order_id)
    {
        $this->order = Order::with('orderItems.product')->findOrFail($order_id);
    }

    public function render()
    {
        return view('livewire.front.order-detail');
    }
}
