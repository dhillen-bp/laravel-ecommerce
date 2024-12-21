<?php

namespace App\Livewire\Front;

use App\Models\City;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
    public $email_verified_at;

    public $current_password;
    public $new_password;
    public $confirm_password;

    public $province_id;
    public $city_id;
    public $address;
    public $postal_code;
    public $provinces = [];
    public $cities = [];

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->email_verified_at = $this->user->email_verified_at;
        $this->address = $this->user->address;
        $this->postal_code = $this->user->postal_code;

        $this->province_id = $this->user->province_id;
        $this->city_id = $this->user->city_id;
        $this->provinces = Province::all();
        if ($this->province_id) {
            $this->cities = City::where('province_id', $this->province_id)->get();
        }
    }

    public function updatedProvinceId($provinceId)
    {
        Log::info('Province ID updated to: ' . $provinceId);
        $this->cities = City::where('province_id', $provinceId)->get();
        $this->city_id = null;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'province_id' => 'nullable|exists:provinces,id',
            'city_id' => 'nullable|exists:cities,id',
            'address' => 'nullable',
            'postal_code' => 'nullable|digits:5',
        ];
    }

    public function updateProfile()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
        ]);

        $updatedUser = $this->user->fresh();

        $this->dispatch('profileUpdated', $this->user);
        Toaster::success('Profil berhasil diperbarui!');
        // $this->redirect(route('front.my_profile'), navigate: true);
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
