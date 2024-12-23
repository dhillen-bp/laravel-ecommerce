<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Masmerise\Toaster\Toaster;

#[Title('Reset Password')]
class ResetPassword extends Component
{
    public $email;
    public $password;
    public $password_confirmation;
    public $token;

    protected function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required',
        ];
    }

    public function mount($token)
    {
        $this->token = $token;
    }

    public function submit()
    {
        $status = Password::reset(
            $this->validate(),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            Toaster::success('Link reset password telah dikirim ke email Anda.');

            return $this->redirect(route('front.login'), navigate: true);
        } else {
            Toaster::error("Terdapat kesalahan saat reset password.");
            return;
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
