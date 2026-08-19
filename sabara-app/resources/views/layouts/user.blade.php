<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SABARA') }}</title>
        <meta name="theme-color" content="#2998BD">
        <link rel="manifest" href="/manifest.json">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white pb-24 selection:bg-[#76C5E3] selection:text-white">
        
        <main class="min-h-screen max-w-md mx-auto">
            {{ $slot }}
        </main>

        <!-- Bottom Navigation Bar (Figma Style) -->
        <nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-gray-100 shadow-[0_-4px_20px_rgba(0,0,0,0.04)]">
            <div class="max-w-md mx-auto px-6 h-20 flex justify-between items-center">
                <!-- Beranda -->
                <a href="/beranda" class="flex flex-col items-center justify-center transition-all duration-200 {{ request()->is('beranda*') ? 'bg-[#DCF3FB] text-[#2998BD] px-6 py-2 rounded-2xl font-bold' : 'text-gray-400 hover:text-gray-600 px-3 py-2 font-medium' }}">
                    <svg class="w-6 h-6 mb-0.5 {{ request()->is('beranda*') ? 'stroke-[2.5]' : 'stroke-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-xs">Beranda</span>
                </a>

                <!-- Peringkat (Leaderboard / Kuis) -->
                <a href="/kuis" class="flex flex-col items-center justify-center transition-all duration-200 {{ request()->is('kuis*') ? 'bg-[#DCF3FB] text-[#2998BD] px-6 py-2 rounded-2xl font-bold' : 'text-gray-400 hover:text-gray-600 px-3 py-2 font-medium' }}">
                    <svg class="w-6 h-6 mb-0.5 {{ request()->is('kuis*') ? 'stroke-[2.5]' : 'stroke-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <span class="text-xs">Peringkat</span>
                </a>

                <!-- Profil -->
                <a href="/profil" class="flex flex-col items-center justify-center transition-all duration-200 {{ request()->is('profil*') ? 'bg-[#DCF3FB] text-[#2998BD] px-6 py-2 rounded-2xl font-bold' : 'text-gray-400 hover:text-gray-600 px-3 py-2 font-medium' }}">
                    <svg class="w-6 h-6 mb-0.5 {{ request()->is('profil*') ? 'stroke-[2.5]' : 'stroke-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-xs">Profil</span>
                </a>
            </div>
        </nav>

        @livewireScripts
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js');
                });
            }
        </script>
    </body>
</html>
