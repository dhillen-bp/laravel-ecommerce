<?php

namespace App\Livewire\Components;

use Livewire\Component;

class PaymentStatusBadge extends Component
{
    public $status;

    public function mount($status)
    {
        $this->status = $status;
    }

    public function render()
    {
        return view('livewire.components.payment-status-badge');
    }
}
