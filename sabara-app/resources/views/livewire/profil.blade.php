<div>
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-8 text-center rounded-b-[2.5rem] shadow-md relative">
        <h1 class="text-xl font-bold text-white mb-4">Profil Saya</h1>
        
        <!-- Avatar Section -->
        <div class="relative w-24 h-24 mx-auto mb-2">
            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg bg-white relative">
                @if ($avatar)
                    <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                @elseif($user->avatar_url)
                    <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                @else
                    <svg class="w-full h-full text-gray-300 mt-2" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                @endif
            </div>
            
            <label class="absolute bottom-0 right-0 w-8 h-8 bg-green-500 rounded-full border-2 border-white flex items-center justify-center cursor-pointer shadow-sm hover:bg-green-600 transition">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <input type="file" wire:model="avatar" class="hidden" accept="image/*">
            </label>
        </div>
        <div wire:loading wire:target="avatar" class="text-white text-xs mt-1">Mengunggah...</div>
        
        <p class="text-green-50 text-sm mt-2">{{ $user->email }}</p>
    </div>

    <!-- Main Content -->
    <div class="px-6 mt-6 pb-8 space-y-6">
        @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p class="text-sm">{{ session('message') }}</p>
            </div>
        @endif

        <!-- Edit Profile Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-4">
            <h2 class="text-gray-800 font-bold text-sm uppercase tracking-wider mb-2">Informasi Akun</h2>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" wire:model="name" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2.5">
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bahasa yang Dipelajari</label>
                <div class="w-full bg-gray-50 rounded-xl border border-gray-200 px-3 py-2.5 flex items-center justify-between">
                    <span class="text-sm text-gray-800 font-medium">{{ $user->selectedLanguage ? $user->selectedLanguage->name : 'Belum memilih' }}</span>
                    <a wire:navigate href="/pilih-bahasa" class="text-xs text-green-600 font-semibold hover:text-green-700">Ubah</a>
                </div>
            </div>

            <button wire:click="updateProfile" wire:loading.attr="disabled" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-xl transition shadow-sm mt-2">
                Simpan Perubahan
            </button>
        </div>

        <!-- Stats Grid -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h2 class="text-gray-800 font-bold text-sm uppercase tracking-wider mb-4">Statistik Belajar</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-orange-50 rounded-xl p-3 border border-orange-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                        <span class="text-lg">⭐</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 font-bold uppercase">Total Poin</p>
                        <p class="text-lg font-bold text-gray-800 leading-tight">{{ number_format($stats['totalPoints']) }}</p>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-xl p-3 border border-blue-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                        <span class="text-lg">🏆</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 font-bold uppercase">Ranking</p>
                        <p class="text-lg font-bold text-gray-800 leading-tight">#{{ $stats['rank'] }}</p>
                    </div>
                </div>

                <div class="bg-purple-50 rounded-xl p-3 border border-purple-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center shrink-0">
                        <span class="text-lg">📝</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 font-bold uppercase">Total Latihan</p>
                        <p class="text-lg font-bold text-gray-800 leading-tight">{{ $stats['totalLatihan'] }}</p>
                    </div>
                </div>

                <div class="bg-green-50 rounded-xl p-3 border border-green-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                        <span class="text-lg">🎯</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 font-bold uppercase">Akurasi Kuis</p>
                        <p class="text-lg font-bold text-gray-800 leading-tight">{{ $stats['accuracy'] }}%</p>
                    </div>
                </div>
                
                <div class="bg-teal-50 rounded-xl p-3 border border-teal-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center shrink-0">
                        <span class="text-lg">💪</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 font-bold uppercase">Poin Latihan</p>
                        <p class="text-lg font-bold text-gray-800 leading-tight">{{ number_format($stats['latihanPoints']) }}</p>
                    </div>
                </div>
                
                <div class="bg-yellow-50 rounded-xl p-3 border border-yellow-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center shrink-0">
                        <span class="text-lg">🏅</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 font-bold uppercase">Skor Kuis Max</p>
                        <p class="text-lg font-bold text-gray-800 leading-tight">{{ $stats['quizMax'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout Action -->
        <div class="pt-4">
            <button wire:click="logout" class="w-full flex justify-center items-center py-2.5 px-4 border-2 border-red-500 rounded-xl text-red-500 bg-white hover:bg-red-50 font-semibold transition text-sm shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Keluar Aplikasi
            </button>
        </div>
    </div>
</div>
