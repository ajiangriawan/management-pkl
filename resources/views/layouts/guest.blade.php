<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">
        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24">
            </a>
        </div>

        <!-- Form -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-700">SMK PGRI 2 PALEMBANG</h2>
        </div>

        {{ $slot }}
    </div>
</body>

</html>