<div class="px-5 pt-8 pb-36 font-sans max-w-md mx-auto">
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs font-bold shadow-xs">
            {{ session('message') }}
        </div>
    @endif

    <!-- Profile Header (Centered) -->
    <div class="flex flex-col items-center text-center">
        <!-- Big Avatar Circle -->
        <div class="relative w-28 h-28 mb-3">
            <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-[#DCF3FB] shadow-xs bg-white flex items-center justify-center p-1">
                @if($user->avatar_url)
                    <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover rounded-full" alt="{{ $user->name }}">
                @else
                    <!-- Balai Bahasa Logo as default -->
                    <svg viewBox="0 0 60 60" class="w-full h-full" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="60" height="60" rx="30" fill="#F0F9FF"/>
                        <path d="M14 18 H26 C30 18, 33 21, 33 25 C33 27.5, 31 29.5, 29 30 C32 30.5, 34 33, 34 36 C34 40, 30 43, 25 43 H14 Z" fill="#38BDF8" fill-opacity="0.3" stroke="#0284C7" stroke-width="3" stroke-linejoin="round"/>
                        <text x="32" y="22" font-size="6.5" font-weight="900" fill="#0369A1" font-family="sans-serif">Balai</text>
                        <text x="32" y="30" font-size="6.5" font-weight="900" fill="#0369A1" font-family="sans-serif">Bahasa</text>
                        <text x="32" y="37" font-size="5" font-weight="700" fill="#0284C7" font-family="sans-serif">Provinsi</text>
                        <text x="32" y="44" font-size="5" font-weight="700" fill="#0284C7" font-family="sans-serif">Bengkulu</text>
                    </svg>
                @endif
            </div>

            <!-- Edit Photo Button Badge -->
            <button wire:click="openEditModal" class="absolute bottom-0 right-0 w-8 h-8 bg-[#2998BD] rounded-full border-2 border-white flex items-center justify-center text-white shadow-xs hover:bg-[#207a97] transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </button>
        </div>

        <!-- Name & Email -->
        <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">
            {{ $user->name }}
        </h1>
        <p class="text-slate-500 text-sm font-medium mt-0.5">
            {{ $user->email }}
        </p>

        <!-- Language Pill -->
        <a href="/pilih-bahasa" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-[#DCF3FB] text-[#2998BD] rounded-full text-xs font-bold shadow-xs hover:bg-[#c9edf8] transition mt-2.5">
            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" />
            </svg>
            <span>{{ $user->selectedLanguage ? $user->selectedLanguage->name : 'Bahasa Bengkulu' }}</span>
        </a>
    </div>

    <!-- Stats Grid (2 Cards) -->
    <div class="grid grid-cols-2 gap-3 mt-6">
        <!-- Rank Card -->
        <div class="bg-[#FAF6ED] border border-[#F2ECE0] rounded-[24px] p-4 flex items-center gap-3 shadow-xs">
            <div class="w-11 h-11 relative flex items-center justify-center shrink-0">
                <!-- 3D Golden Trophy SVG -->
                <svg viewBox="0 0 80 80" class="w-10 h-10 drop-shadow-sm" fill="none">
                    <defs>
                        <linearGradient id="goldGradProf" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#FDE047"/>
                            <stop offset="60%" stop-color="#EAB308"/>
                            <stop offset="100%" stop-color="#CA8A04"/>
                        </linearGradient>
                    </defs>
                    <path d="M16 26 C8 26, 8 46, 22 48 M64 26 C72 26, 72 46, 58 48" stroke="#EAB308" stroke-width="5" fill="none" stroke-linecap="round"/>
                    <path d="M20 22 L60 22 C60 38, 52 52, 40 54 C28 52, 20 38, 20 22 Z" fill="url(#goldGradProf)"/>
                    <path d="M37 54 L43 54 L45 64 L35 64 Z" fill="#CA8A04"/>
                    <rect x="28" y="64" width="24" height="6" rx="2" fill="#475569"/>
                    <polygon points="40,28 43,35 50,35 45,40 47,47 40,42 33,47 35,40 30,35 37,35" fill="#FEF08A"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-black text-slate-900 leading-none tracking-tight">#{{ $stats['rank'] }}</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Peringkat</p>
            </div>
        </div>

        <!-- Points Card -->
        <div class="bg-[#FAF6ED] border border-[#F2ECE0] rounded-[24px] p-4 flex items-center gap-3 shadow-xs">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500 to-amber-400 text-white flex items-center justify-center shadow-[0_4px_10px_rgba(245,158,11,0.35)] shrink-0">
                <svg class="w-6 h-6 fill-white" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
            <div>
                <p class="text-xl font-black text-slate-900 leading-none tracking-tight">{{ $stats['totalPoints'] }}</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Total Poin</p>
            </div>
        </div>
    </div>

    <!-- SECTION TITLE: PENGATURAN -->
    <div class="mt-8 mb-3 px-1">
        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">
            Pengaturan
        </p>
    </div>

    <!-- SETTINGS MENU LIST (White Card Container) -->
    <div class="bg-white rounded-[28px] border border-gray-100 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden divide-y divide-gray-50">
        <!-- 1. Ubah Profil -->
        <button wire:click="openEditModal" class="w-full p-4 flex items-center justify-between hover:bg-slate-50 transition text-left">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-[#E0F2FE] text-[#0284C7] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <span class="font-bold text-sm text-slate-800">Ubah Profil</span>
            </div>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- 2. Ganti Bahasa -->
        <a href="/pilih-bahasa" class="w-full p-4 flex items-center justify-between hover:bg-slate-50 transition">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-[#DCFCE7] text-[#16A34A] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                </div>
                <span class="font-bold text-sm text-slate-800">Ganti Bahasa</span>
            </div>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>

        <!-- 3. Tentang Aplikasi -->
        <button wire:click="$set('showAboutModal', true)" class="w-full p-4 flex items-center justify-between hover:bg-slate-50 transition text-left">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-[#E0F2FE] text-[#0284C7] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="font-bold text-sm text-slate-800">Tentang Aplikasi</span>
            </div>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- 4. Keluar (Logout) -->
        <button wire:click="logout" onclick="return confirm('Yakin ingin keluar dari aplikasi?') || event.stopImmediatePropagation()" class="w-full p-4 flex items-center justify-between hover:bg-rose-50/50 transition text-left group">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-[#FFE4E6] text-[#E11D48] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </div>
                <span class="font-bold text-sm text-[#E11D48]">Keluar</span>
            </div>
            <svg class="w-4 h-4 text-rose-300 group-hover:text-rose-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>

    <!-- UBAH PROFIL MODAL -->
    @if($showEditModal)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl space-y-4 relative animate-in fade-in zoom-in duration-200">
            <h3 class="text-lg font-bold text-slate-900 border-b pb-3">
                Ubah Profil
            </h3>

            <form wire:submit="updateProfile" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Foto Profil</label>
                    <input type="file" wire:model="avatar" accept="image/*" class="w-full text-xs text-slate-500 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-sky-50 file:text-sky-700">
                    @error('avatar') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:border-[#2998BD] focus:outline-none">
                    @error('name') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="pt-3 flex items-center justify-end gap-2 border-t">
                    <button type="button" wire:click="$set('showEditModal', false)" class="px-4 py-2 bg-slate-100 rounded-xl font-semibold text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#2998BD] hover:bg-[#207a97] text-white font-bold rounded-xl text-sm shadow">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- TENTANG APLIKASI MODAL -->
    @if($showAboutModal)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl space-y-4 relative animate-in fade-in zoom-in duration-200">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-[#DCF3FB] text-[#2998BD] flex items-center justify-center mx-auto mb-3">
                    <span class="text-3xl">🌊</span>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900">SABARA</h3>
                <p class="text-xs text-slate-500 font-semibold">Sarana Belajar Bahasa Daerah Bengkulu</p>
            </div>

            <div class="text-xs text-slate-600 space-y-2 py-2 leading-relaxed bg-slate-50 p-4 rounded-2xl border">
                <p><strong>SABARA</strong> adalah platform pembelajaran bahasa daerah interaktif berbasis web yang dikembangkan bersama <strong>Balai Bahasa Provinsi Bengkulu</strong>.</p>
                <p>Dilengkapi dengan materi percakapan, latihan interaktif berbagai tipe soal, dan kuis gamifikasi untuk melestarikan bahasa daerah.</p>
            </div>

            <div class="pt-2 flex justify-center">
                <button type="button" wire:click="$set('showAboutModal', false)" class="w-full py-2.5 bg-[#2998BD] text-white font-bold rounded-xl text-sm shadow">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
