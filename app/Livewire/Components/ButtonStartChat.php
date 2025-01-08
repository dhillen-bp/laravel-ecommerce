<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ButtonStartChat extends Component
{
    public $toId;
    public $contextId;

    public function render()
    {
        return view('livewire.components.button-start-chat');
    }

    public function getRouteProperty()
    {
        return route('chat.context', [$this->toId, $this->contextId]);
    }
}
