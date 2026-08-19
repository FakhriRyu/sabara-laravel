<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#16a34a">
    <link rel="manifest" href="/manifest.json">
    <title>{{ config('app.name', 'SABARA') }} - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-slate-900/50 lg:hidden" @click="sidebarOpen = false" x-transition.opacity></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 text-white transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-auto flex flex-col">
        <div class="flex items-center justify-center h-16 bg-slate-950 px-4 border-b border-slate-800">
            <span class="text-xl font-bold flex items-center gap-2">
                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd"></path></svg>
                SABARA Admin
            </span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>📊</span> Dashboard
            </a>
            <a href="{{ route('admin.materi') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.materi*') ? 'bg-green-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>📚</span> Materi
            </a>
            <a href="{{ route('admin.kuis') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.kuis*') ? 'bg-green-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>📝</span> Kuis
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.users*') ? 'bg-green-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>👥</span> Users
            </a>
            <a href="{{ route('admin.pengunjung') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.pengunjung*') ? 'bg-green-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>👁️</span> Pengunjung
            </a>
            <a href="{{ route('admin.sound-effects') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.sound-effects*') ? 'bg-green-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>🔊</span> Sound Effects
            </a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg">
                    <span>🚪</span> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top header -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="text-slate-500 focus:outline-none lg:hidden mr-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-xl font-semibold text-slate-800">
                    @yield('title', 'Admin Dashboard')
                </h1>
            </div>
            <div class="flex items-center gap-4">
                <!-- Language Switcher -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900 focus:outline-none">
                        <span>🌐 {{ session('admin_language_id', 'Semua Bahasa') }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5" style="display: none;">
                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Bengkulu</a>
                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Semua Bahasa</a>
                    </div>
                </div>
                <!-- Admin Profile -->
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-bold">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="hidden sm:block text-sm">
                        <p class="font-medium text-slate-900">{{ auth()->user()->name ?? 'Admin User' }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()->role ?? 'Administrator' }}</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6 lg:p-8">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>
</html>
