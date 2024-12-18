<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('Verify Email')]
class VerifyEmail extends Component
{
    public $isLoading = false;

    public function mount()
    {
        // Cek apakah pengguna sudah terverifikasi
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            Toaster::warning("Email anda sudah diverifikasi!");
            return $this->redirectRoute('front.my_profile', navigate: true);
        }
    }

    public function sendVerificationEmail()
    {
        $this->isLoading = true;

        $user = Auth::user();

        if ($user) {
            if ($user->hasVerifiedEmail()) {
                Toaster::success("Email anda sudah diverifikasi!");
            } else {
                $user->sendEmailVerificationNotification();
                Toaster::success("Email verifikasi berhasil dikirimkan ulang!");
            }
        } else {
            Toaster::error("Email verifikasi gagal dikirimkan ulang!;");
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
