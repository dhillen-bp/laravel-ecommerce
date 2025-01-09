<div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
    <button id="dropdown-scrollable" type="button" class="dropdown-toggle flex items-center" aria-haspopup="menu"
        aria-expanded="false" aria-label="Dropdown">
        <div class="avatar">
            <div class="size-9.5 rounded-full">
                <img src="{{ asset('images/account.jpeg') }}" alt="avatar 1" />
            </div>
        </div>
    </button>
    <ul class="dropdown-menu hidden min-w-60 dropdown-open:opacity-100" role="menu" aria-orientation="vertical"
        aria-labelledby="dropdown-avatar">
        <li class="dropdown-header gap-2">
            <div class="avatar">
                <div class="w-10 rounded-full">
                    <img src="{{ asset('images/account.jpeg') }}" alt="avatar" />
                </div>
            </div>
            <div>
                <h6 class="text-base font-semibold text-base-content/90">{{ $user->name }}</h6>
                <small class="text-base-content/50">{{ $user->roles->first()->name }}</small>
            </div>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('front.my_profile') }} " wire:navigate>
                <span class="icon-[tabler--user]"></span>
                Profil Saya
            </a>
        </li>
        @if (auth()->user()->hasRole('customer'))
            <li>
                <a class="dropdown-item" href="{{ route('front.order') }}" wire:navigate>
                    <span class="icon-[tabler--settings]"></span>
                    Pesanan Saya
                </a>
            </li>
        @endif
        <li class="dropdown-footer gap-2">
            @livewire('auth.logout-button')
        </li>
    </ul>
</div>
