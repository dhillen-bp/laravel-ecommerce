<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" class="bg-tertiary-green">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>{{ $title ?? 'App' }} - Laravel Olsop</title>

    @livewireStyles
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script> --}}
</head>

<body class="text-font-default min-h-screen antialiased">

    <x-navigation />

    <!-- Page Content -->
    <main>
        {{-- {{ $slot }} --}}
        @isset($slot)
            {{ $slot }}  <!-- Menampilkan konten jika $slot ada -->
        @else
            @yield('content')  <!-- Menampilkan konten default jika $slot tidak ada -->
        @endisset
    </main>

    <x-footer />

    <x-toaster-hub />
    @stack('after-script')
    @livewireScripts
</body>

</html>
