<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-between max-w-md mx-auto w-full">
        <!-- Top Branding Section -->
        <div class="pt-10 pb-8 px-6 flex flex-col items-center justify-center">
            <div class="flex items-center justify-center gap-3.5">
                <!-- Seahorse Mascot SVG -->
                <div class="relative w-14 h-18 shrink-0">
                    <svg viewBox="0 0 100 120" class="w-full h-full drop-shadow-sm" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="18" cy="28" r="4" fill="#67d4ed" fill-opacity="0.6"/>
                        <circle cx="85" cy="24" r="3.5" fill="#67d4ed" fill-opacity="0.6"/>
                        <circle cx="14" cy="55" r="2.5" fill="#67d4ed" fill-opacity="0.5"/>
                        <circle cx="88" cy="48" r="4" fill="#67d4ed" fill-opacity="0.5"/>
                        
                        <defs>
                            <linearGradient id="seahorseGradReg" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#4de1f7"/>
                                <stop offset="50%" stop-color="#22b8d9"/>
                                <stop offset="100%" stop-color="#1894b8"/>
                            </linearGradient>
                            <linearGradient id="bellyGradReg" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#b6f4ff"/>
                                <stop offset="100%" stop-color="#6be3f7"/>
                            </linearGradient>
                        </defs>
                        
                        <path d="M36 48 C28 42, 28 62, 38 65" fill="#58d9ef" opacity="0.8"/>
                        <path d="M48 18 C46 12, 53 10, 56 16 C60 11, 67 13, 67 20" fill="url(#seahorseGradReg)"/>
                        <path d="M50 20 C42 22, 38 28, 40 36 C41 40, 48 45, 52 46 C48 52, 46 62, 52 72 C56 78, 58 84, 52 90 C46 96, 42 90, 45 84 C46 82, 44 80, 42 82 C38 88, 42 102, 54 100 C64 98, 66 84, 60 74 C56 66, 56 58, 62 50 C68 42, 70 32, 62 24 C58 20, 54 20, 50 20 Z" fill="url(#seahorseGradReg)"/>
                        <path d="M42 28 C34 27, 28 30, 26 33 C26 36, 32 37, 40 35 Z" fill="url(#seahorseGradReg)"/>
                        
                        <path d="M44 48 C48 47, 56 50, 58 56 C50 56, 46 54, 44 48 Z" fill="url(#bellyGradReg)"/>
                        <path d="M46 57 C50 56, 56 59, 57 65 C50 65, 47 62, 46 57 Z" fill="url(#bellyGradReg)"/>
                        <path d="M48 66 C51 65, 55 67, 56 72 C51 72, 48 70, 48 66 Z" fill="url(#bellyGradReg)"/>
                        
                        <circle cx="52" cy="27" r="3.5" fill="#ffffff"/>
                        <circle cx="52.5" cy="27" r="2" fill="#164e63"/>
                        <circle cx="53.5" cy="26" r="0.8" fill="#ffffff"/>
                        <ellipse cx="46" cy="33" rx="2.5" ry="1.5" fill="#ff7da7" opacity="0.6"/>
                    </svg>
                </div>
                
                <div>
                    <h1 class="text-3xl font-black text-white tracking-wider drop-shadow-sm leading-none">SABARA</h1>
                    <p class="text-white text-xs font-semibold tracking-tight mt-1.5 opacity-95">sahabat bahasa daerah</p>
                </div>
            </div>
        </div>

        <!-- White Bottom Sheet Card -->
        <div class="bg-white rounded-t-[36px] px-8 pt-7 pb-10 shadow-2xl flex-1 flex flex-col justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Daftar Akun</h2>

                <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               autocomplete="name"
                               placeholder="Nama Lengkap" 
                               class="w-full px-5 py-3 rounded-2xl border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#74C5E3] focus:ring-2 focus:ring-[#74C5E3]/20 transition text-sm bg-white" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                    </div>

                    <!-- Email Input -->
                    <div>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="username"
                               placeholder="Alamat pos-el (email)" 
                               class="w-full px-5 py-3 rounded-2xl border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#74C5E3] focus:ring-2 focus:ring-[#74C5E3]/20 transition text-sm bg-white" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                    </div>

                    <!-- Password Input -->
                    <div>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               placeholder="Kata sandi" 
                               class="w-full px-5 py-3 rounded-2xl border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#74C5E3] focus:ring-2 focus:ring-[#74C5E3]/20 transition text-sm bg-white" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               placeholder="Konfirmasi kata sandi" 
                               class="w-full px-5 py-3 rounded-2xl border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#74C5E3] focus:ring-2 focus:ring-[#74C5E3]/20 transition text-sm bg-white" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full py-3.5 px-4 bg-[#76C5E3] hover:bg-[#60B6D6] text-white font-bold rounded-2xl shadow-sm transition active:scale-[0.99] text-base">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center text-xs text-gray-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-[#76C5E3] hover:text-[#52AFD1] transition">Masuk di sini</a>
            </div>
        </div>
    </div>
</x-guest-layout>
