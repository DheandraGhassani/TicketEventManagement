<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TicketIN') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4">

        {{-- Logo --}}
        <div class="flex items-center gap-2 mb-4">
            <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
            </div>
            <span class="font-semibold text-gray-800 text-xl">{{ config('app.name', 'TicketIN') }}</span>
        </div>

        <p class="text-gray-500 text-sm mb-8">Platform tiket event online</p>

        {{-- Card --}}
        <div class="w-full max-w-xs bg-white rounded-xl shadow p-8 text-center">
            <h1 class="text-base font-semibold text-gray-800 mb-1">Selamat datang</h1>
            <p class="text-sm text-gray-500 mb-6">Beli tiket event favoritmu dengan mudah.</p>

            <div class="space-y-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="block w-full px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="block w-full px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="block w-full px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>

        <p class="mt-8 text-xs text-gray-400">&copy; {{ date('Y') }} {{ config('app.name', 'TicketIN') }}</p>
    </div>
</body>

</html>
