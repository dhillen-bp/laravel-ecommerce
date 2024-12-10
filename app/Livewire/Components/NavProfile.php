<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class NavProfile extends Component
{
    public $user;

    protected $listeners = ['profileUpdated' => 'loadProfile'];

    public function mount()
    {
        $this->loadProfile();
    }

    public function loadProfile()
    {
        // Cek apakah data ada di cache, jika ada ambil dan deserialisasi
        $cachedUser = Cache::get('user_' . Auth::id());

        if ($cachedUser) {
            $this->user = unserialize($cachedUser);  // Convert kembali ke instance User
        } else {
            // Jika tidak ada di cache, ambil data dari Auth dan simpan ke cache
            $this->user = Auth::user();
            Cache::put('user_' . Auth::id(), serialize($this->user), now()->addMinutes(10));
        }
    }

    public function render()
    {
        return view('livewire.components.nav-profile');
    }
}
