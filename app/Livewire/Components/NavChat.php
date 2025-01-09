<?php

namespace App\Livewire\Components;

use App\Models\ChMessage;
use Livewire\Component;

class NavChat extends Component
{
    public $countUnseenMessage;

    public function mount()
    {
        $unseenMessage = ChMessage::where('id', auth()->id())->where('seen', 0)->get();
        $this->countUnseenMessage = count($unseenMessage);
    }

    public function render()
    {
        return view('livewire.components.nav-chat');
    }
}
