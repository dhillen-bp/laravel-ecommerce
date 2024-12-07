<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\LoginForm;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
class Login extends Component
{
    public LoginForm $form;

    public function login()
    {
        $this->form->authenticate();
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
