<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class ButtonStartChat extends Component
{
    public $toId;
    public $contextId;
    public $admins = [];
    public $showModal = false;

    public function mount()
    {
        $this->admins = Role::where('name', 'owner')
            ->first()
            ->users()
            ->get(['id', 'name', 'active_status']);
    }

    public function render()
    {
        return view('livewire.components.button-start-chat');
    }

    public function selectAdmin($adminId)
    {
        $this->toId = $adminId;
        $this->showModal = false;

        // Redirect ke halaman chat setelah admin dipilih
        return $this->redirect(route('chat.context', [$this->toId, $this->contextId]), navigate: true);
    }
}
