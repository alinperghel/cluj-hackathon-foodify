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
        <livewire:styles />
    </head>
    <body>
        <div class="flex-shrink-0 justify-center bg-gray-100 dark:bg-gray-900 pt-8 pb-4">
            <img class="h-20 mx-auto" src="{{ asset('images/logo.png') }}" alt="logo">
        </div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            {{ $slot }}
        </div>
        <livewire:scripts />
    </body>
</html>
