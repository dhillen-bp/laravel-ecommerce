<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Login')]
class Login extends Component
{
    public LoginForm $form;

    public function mount()
    {
        if (auth()->check()) {
            Toaster::warning("Anda sudah login!");
            // Redirect user to the dashboard if they are already logged in
            return $this->redirect(route('front.my_profile'), navigate: true);
        }
    }

    public function login()
    {
        $this->form->validate();

        if (Auth::attempt(['email' => $this->form->email, 'password' => $this->form->password])) {
            session()->regenerate();

            Toaster::success('Anda berhasil login!');
            return $this->redirect(route('front.my_profile'), navigate: true);
        }

        Toaster::error('Anda gagal login!');
        return;
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
