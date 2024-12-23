<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Masmerise\Toaster\Toaster;

class LoginForm extends Form
{
    public ?User $user;

    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    // public function authenticate()
    // {
    //     $this->validate();

    //     if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
    //         session()->regenerate();

    //         Toaster::success('Anda berhasil login!');
    //     }

    //     Toaster::error('Anda gagal login!');
    // }
}
