@props(['title' => 'Anime List'])

    <!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
{{-- Simple site header --}}
<header class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
        <a href="{{ route('landing') }}" class="font-semibold">
            🗂️ Anime List
        </a>
        <nav class="text-sm flex gap-4">
            <a class="hover:underline" href="{{ route('landing') }}">Home</a>
            <a class="hover:underline" href="{{ route('series.index') }}">Series (admin)</a>
            <a class="hover:underline" href="{{ route('publishers.index') }}">Publishers (admin)</a>
        </nav>
    </div>
</header>

<main class="py-6">
    {{ $slot }}
</main>
</body>
</html>
