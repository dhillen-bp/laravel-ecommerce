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
        $this->order = Order::findOrFail($order_id);
        $this->user = Auth::user();
    }


    public function render()
    {
        return view('livewire.front.payment');
    }
}
