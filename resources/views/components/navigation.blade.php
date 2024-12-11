<nav class="navbar fixed z-50 flex w-full gap-2 px-8 py-3 shadow max-md:flex-col md:items-center md:px-16 md:py-4">
    <!-- Logo dan Hamburger Menu di Mobile -->
    <div class="flex items-center justify-between max-md:w-full">
        <div class="navbar-start items-center justify-between max-md:w-full">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/laravel.svg') }}" alt="Laravel Olsop" class="w-8 md:w-10">
                <span class="text-xl font-bold">Olsop</span>
            </div>

            <div class="flex flex-row items-center justify-center gap-3 md:hidden">
                <!-- Tombol Reservasi di Mobile -->
                <div class="w-full text-center">
                    <button class="btn btn-success btn-outline btn-sm">
                        <span class="text-btn-success">Reservasi</span>
                    </button>
                </div>

                <!-- Hamburger Icon for Mobile -->
                <button type="button" class="btn btn-square btn-secondary btn-outline collapse-toggle btn-sm"
                    data-collapse="#dropdown-navbar-collapse" aria-controls="dropdown-navbar-collapse"
                    aria-label="Toggle navigation">
                    <span class="size-4 icon-[tabler--menu-2] collapse-open:hidden"></span>
                    <span class="size-4 icon-[tabler--x] hidden collapse-open:block"></span>
                </button>

            </div>
        </div>
    </div>

    <!-- Dropdown Menu untuk Mobile -->
    <div id="dropdown-navbar-collapse"
        class="collapse hidden grow basis-full overflow-hidden transition-[height] duration-300 md:navbar-start max-md:w-full md:justify-center">
        <ul class="menu p-0 text-center text-base md:menu-horizontal md:mr-3 md:gap-8">
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
        <div class="flex items-center justify-end gap-6">
            @auth()
                @if (auth()->user()->hasRole('customer'))
                    <!-- Cart -->
                    @livewire('front.cart.nav-cart')

                    <!-- Profile -->
                    @livewire('components.nav-profile')
                @else
                    <a href="{{ route('front.login') }}" class="btn btn-success btn-outline" wire:navigate>
                        Login
                    </a>
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
