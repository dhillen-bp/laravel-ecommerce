<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\RegisterForm;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register')]
class Register extends Component
{
    public RegisterForm $form;

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('front.my_profile', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
