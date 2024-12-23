<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class LogoutButton extends Component
{
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        Toaster::success('Anda berhasil logout!');
        return $this->redirect(route('front.login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.logout-button');
    }
}
