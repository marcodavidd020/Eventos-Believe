@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    @if (Auth::user()->style == 'young')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Freckle+Face&display=swap" rel="stylesheet">
    @elseif (Auth::user()->style == 'senior')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    @else
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    @endif

    <!-- Flowbite CSS -->
    <link href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="{{ Auth::user()->style == 'young' ? 'font-freckle bg-young' : (Auth::user()->style == 'senior' ? 'font-lora font-senior bg-senior' : 'font-sans bg-adult') }} antialiased {{ $theme === 'dark' ? 'bg-gray-900 text-white' : 'text-gray-900' }}">
    <x-banner />

    <div class="min-h-screen">
        {{ Auth::user()->role->nombre == 'Usuario'
            ? view('navigation-menu-client')
            : view('navigation-menu')
        }}

        <!-- Page Heading -->
        @if (isset($header))
            <header class="{{ $theme === 'dark' ? 'bg-gray-800' : 'bg-white' }} shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="{{ $theme === 'dark' ? 'dark:bg-gray-900' : '' }} {{ $theme === 'dark' ? 'h-screen' : '' }} ">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>

<!-- Flowbite JS -->
<script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>

</html>
