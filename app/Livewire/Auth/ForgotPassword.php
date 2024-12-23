<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Masmerise\Toaster\Toaster;

#[Title('Forgot Password')]
class ForgotPassword extends Component
{
    public $email;

    protected function rules()
    {
        return [
            'email' => 'required|string|email',
        ];
    }

    public function submit()
    {
        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            Toaster::success('Link reset password telah dikirim ke email Anda. ' . $status);
            // return $this->redirect(route('password.request'), navigate: true);
        } else {
            Toaster::error("Terdapat kesalahan saat mengirim email " . $status);
            // return $this->redirect(route('password.request'), navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
