<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex h-screen items-center justify-center bg-gray-100">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-orange-500">404</h1>
        <h2 class="mt-4 text-2xl font-semibold text-gray-800">Not Found</h2>
        <p class="mt-2 text-gray-600">Oops! Page not found.</p>
        <div class="mt-6">
            <a href="{{ route('front.index') }}" class="btn btn-success btn-text">
                Return to Homepage
            </a>
        </div>
        <div class="mt-8">
            <img src="https://via.placeholder.com/300x200?text=Access+Denied" alt="Access Denied"
                class="mx-auto rounded-md shadow-lg">
        </div>
    </div>
</body>

</html>
