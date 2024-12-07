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
    use WithFileUploads;

    public $order;
    public $user;
    public $transaction_id;
    public $status;
    public $total_price = 0;
    public $payment_proof;

    public function mount($order_id)
    {
        $this->order = Order::findOrFail($order_id);
        $this->user = Auth::user();
    }

    public function processPayment()
    {
        $this->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $fileName = uniqid('payment_') . '.' . $this->payment_proof->getClientOriginalExtension();
        $filePath = $this->payment_proof->storeAs('payment_proofs', $fileName, 'public');

        ModelsPayment::create([
            'transaction_id' => uniqid('TR-'),
            'order_id' => $this->order->id,
            'status' => 'pending',
            'payment_proof' => $filePath,
        ]);

        Toaster::success('Bukti pembayaran berhasil diunggah. Menunggu verifikasi.');
        return $this->redirect(route('front.order'));
    }

    public function render()
    {
        return view('livewire.front.payment');
    }
}
