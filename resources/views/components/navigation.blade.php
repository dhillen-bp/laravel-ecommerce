<nav class="navbar fixed z-50 flex w-full gap-2 px-8 py-3 shadow max-md:flex-col md:items-center md:px-16 md:py-4">
    <!-- Logo dan Hamburger Menu di Mobile -->
    <div class="flex items-center justify-between max-md:w-full">
        <div class="navbar-start items-center justify-between max-md:w-full">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/laravel.svg') }}" alt="Laravel Olsop" class="w-8 md:w-10">
                <span class="text-xl font-bold">Olsop</span>
            </div>

            <div class="flex flex-row items-center justify-center gap-3 md:hidden">

                @auth()
                    @if (auth()->user()->hasRole('customer'))
                        <div class="navbar-end flex justify-end gap-x-2">
                            @livewire('front.cart.nav-cart')
                            {{-- @livewire('components.nav-notification') --}}
                            @livewire('components.nav-profile')
                        </div>
                    @else
                        @livewire('components.nav-profile')
                    @endif
                @endauth

                @guest
                    <a href="{{ route('front.login') }}" wire:navigate class="btn btn-success btn-outline btn-sm">
                        <span class="text-btn-success">Login</span>
                    </a>
                @endguest

                <!-- Hamburger Icon for Mobile -->
                <button type="button" class="btn btn-square btn-secondary btn-outline collapse-toggle btn-sm"
                    data-collapse="#dropdown-navbar-collapse" aria-controls="dropdown-navbar-collapse"
                    aria-label="Toggle navigation">
                    <span class="icon-[tabler--menu-2] size-4 collapse-open:hidden"></span>
                    <span class="icon-[tabler--x] hidden size-4 collapse-open:block"></span>
                </button>
            </div>

        </div>
    </div>
    </div>

    <!-- Dropdown Menu untuk Mobile -->
    <div id="dropdown-navbar-collapse"
        class="collapse hidden grow basis-full overflow-hidden transition-[height] duration-300 md:navbar-start max-md:w-full md:justify-center">
        <ul
            class="menu my-2 space-y-2 p-0 text-start text-base md:menu-horizontal md:mr-3 md:gap-8 md:space-y-0 md:text-center">
            <a href="{{ route('front.index') }}" class="nav-item group" wire:navigate>
                <li class="{{ request()->routeIs('front.index') ? 'font-bold' : '' }} group-hover:font-bold">
                    Beranda</li>
                <span class="nav-underline group-hover:w-full"></span>
            </a>
            <a href="{{ route('front.products') }}" class="nav-item group" wire:navigate>
                <li
                    class="{{ request()->routeIs(['front.products', 'front.products.show']) ? 'font-bold' : '' }} group-hover:font-bold">
                    Product</li>
                <span class="nav-underline group-hover:w-full"></span>
            </a>
            <a href="{{ route('front.about') }}" wire:navigate class="nav-item group">
                <li class="{{ request()->routeIs('front.about') ? 'font-bold' : '' }} group-hover:font-bold">
                    Tentang Kami</li>
                <span class="nav-underline group-hover:w-full"></span>
            </a>
        </ul>
    </div>

    <!-- Desktop Profile -->
    <div class="hidden md:block">
        <div class="flex items-center justify-end gap-3">
            @auth()
                @if (auth()->user()->hasRole('customer'))
                    @livewire('components.nav-chat')
                    @livewire('front.cart.nav-cart')
                    @livewire('components.nav-notification')
                    @livewire('components.nav-profile')
                @else
                    @livewire('components.nav-profile')
                @endif
            @endauth

            @guest
                <a href="{{ route('front.login') }}" class="btn btn-success btn-outline" wire:navigate>
                    Login
                </a>
            @endguest

        </div>
    </div>
</nav>
