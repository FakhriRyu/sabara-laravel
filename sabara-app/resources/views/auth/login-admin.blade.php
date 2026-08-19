<div>
    <!-- Branding -->
    <div class="mb-8 text-center flex flex-col items-center">
        <!-- Shield Icon for Admin -->
        <div class="bg-green-100 p-3 rounded-full mb-3">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold text-green-600 tracking-tight">SABARA Admin</h1>
        <p class="mt-2 text-sm text-gray-600 font-medium">Panel Administrator</p>
    </div>

    @if ($error)
        <div class="mb-4 text-sm text-red-600 bg-red-50 p-3 rounded-xl border border-red-200">
            {{ $error }}
        </div>
    @endif

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Admin</label>
            <input wire:model="email" id="email" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors" type="email" required autofocus autocomplete="username" />
            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input wire:model="password" id="password" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors"
                            type="password" required autocomplete="current-password" />
            @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                Masuk Panel Admin
            </button>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-green-600 transition-colors">
                Kembali ke login pengguna
            </a>
        </div>
    </form>
</div>
