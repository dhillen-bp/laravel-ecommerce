<?php

namespace App\Livewire\Front;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

#[Title('My Profile')]
class MyProfile extends Component
{
    public $user;
    public $name;
    public $email;

    public $current_password;
    public $new_password;
    public $confirm_password;


    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function updateProfile()
    {

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user->id),
            ],
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $updatedUser = $this->user->fresh();

        $this->dispatch('profileUpdated', $this->user);
        Toaster::success('Profil berhasil diperbarui!');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:3',
        ]);

        if (!Hash::check($this->current_password, $this->user->password)) {
            Toaster::error('Password saat ini tidak benar!');
            return;
        }

        if ($this->new_password !== $this->confirm_password) {
            Toaster::error('Konfirmasi password tidak sesuai!');
            return;
        }

        $this->user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'confirm_password']);
        Toaster::success('Password berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.front.my-profile');
    }
}
