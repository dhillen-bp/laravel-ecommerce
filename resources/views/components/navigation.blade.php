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
                <button type="button" class="collapse-toggle btn btn-square btn-secondary btn-outline btn-sm"
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
            <a href="{{ route('front.about') }}" class="nav-item group">
                <li class="{{ request()->routeIs('front.about') ? 'font-bold' : '' }} group-hover:font-bold">
                    Tentang Kami</li>
                <span class="nav-underline group-hover:w-full"></span>
            </a>
        </ul>
    </div>

    <!-- Desktop Profile -->
    <div class="hidden md:block">
        <div class="flex items-center justify-end gap-6">
            <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
                <button id="dropdown-scrollable" type="button"
                    class="dropdown-toggle size-10 btn btn-circle btn-text dropdown-open:bg-base-content/10"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    <div class="indicator">
                        <span class="size-2 indicator-item rounded-full bg-error"></span>
                        <span class="size-[1.375rem] icon-[tabler--shopping-cart] text-base-content"></span>
                    </div>
                </button>
                <div class="dropdown-menu hidden dropdown-open:opacity-100" role="menu" aria-orientation="vertical"
                    aria-labelledby="dropdown-scrollable">
                    <div class="dropdown-header justify-center">
                        <h6 class="text-base text-base-content/90">My Cart</h6>
                    </div>
                    <div
                        class="horizontal-scroll max-sm:max-w-80 vertical-scrollbar rounded-scrollbar max-h-56 w-80 overflow-auto text-base-content/80">
                        <div class="dropdown-item flex gap-4 border-b border-gray-200 p-4">
                            <div class="avatar rounded-none">
                                <div class="w-14 rounded">
                                    <img src="https://via.placeholder.com/150" alt="Product Image">
                                </div>
                            </div>
                            <div class="flex items-start gap-8">
                                <div class="flex flex-col justify-between">
                                    <h6 class="truncate text-sm font-semibold">Product Name</h6>
                                    <small class="text-sm text-gray-600">Qty: 1</small>
                                </div>
                                <div class="flex flex-col justify-between gap-2">
                                    <span class="ml-0 text-sm font-semibold text-green-500">Rp
                                        120.000</span>
                                    <button class="btn btn-error btn-xs">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('front.cart') }}" class="dropdown-footer justify-center gap-1">
                        <span class="size-4 icon-[tabler--eye]"></span>
                        View all
                    </a>
                </div>
            </div>
            <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
                <button id="dropdown-scrollable" type="button" class="dropdown-toggle flex items-center"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    <div class="avatar">
                        <div class="size-9.5 rounded-full">
                            <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png" alt="avatar 1" />
                        </div>
                    </div>
                </button>
                <ul class="min-w-60 dropdown-menu hidden dropdown-open:opacity-100" role="menu"
                    aria-orientation="vertical" aria-labelledby="dropdown-avatar">
                    <li class="dropdown-header gap-2">
                        <div class="avatar">
                            <div class="w-10 rounded-full">
                                <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png" alt="avatar" />
                            </div>
                        </div>
                        <div>
                            <h6 class="text-base font-semibold text-base-content/90">John Doe</h6>
                            <small class="text-base-content/50">Admin</small>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="icon-[tabler--user]"></span>
                            Profil Saya
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="icon-[tabler--settings]"></span>
                            Pesanan Saya
                        </a>
                    </li>
                    <li class="dropdown-footer gap-2">
                        <a class="btn btn-error btn-soft btn-block" href="#">
                            <span class="icon-[tabler--logout]"></span>
                            Sign out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
