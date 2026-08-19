<x-guest-layout>
    <!-- Branding -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-extrabold text-green-600 tracking-tight">SABARA</h1>
        <p class="mt-2 text-sm text-gray-600 font-medium">Sarana Belajar Bahasa Daerah</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-green-600 hover:text-green-800 font-medium transition-colors" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                Masuk
            </button>
        </div>

        <div class="text-center text-sm text-gray-600 mt-4">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-semibold text-green-600 hover:text-green-800 transition-colors">Daftar sekarang</a>
        </div>
    </form>
</x-guest-layout>
