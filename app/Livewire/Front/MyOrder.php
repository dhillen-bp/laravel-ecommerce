<?php

namespace App\Livewire\Front;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Order')]
class MyOrder extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::with('orderItems.productVariant.product', 'orderItems.productVariant.variant', 'payment', 'shipping')->where('user_id', auth()->id())->latest()->get();
    }

    public function render()
    {
        return view('livewire.front.my-order');
    }
}
