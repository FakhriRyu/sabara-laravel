<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-between max-w-md mx-auto w-full">
        <!-- Top Branding Section -->
        <div class="pt-14 pb-10 px-6 flex flex-col items-center justify-center">
            <div class="flex items-center justify-center gap-3.5">
                <!-- Seahorse Mascot SVG -->
                <div class="relative w-16 h-20 shrink-0">
                    <svg viewBox="0 0 100 120" class="w-full h-full drop-shadow-sm" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Bubbles -->
                        <circle cx="18" cy="28" r="4" fill="#67d4ed" fill-opacity="0.6"/>
                        <circle cx="85" cy="24" r="3.5" fill="#67d4ed" fill-opacity="0.6"/>
                        <circle cx="14" cy="55" r="2.5" fill="#67d4ed" fill-opacity="0.5"/>
                        <circle cx="88" cy="48" r="4" fill="#67d4ed" fill-opacity="0.5"/>
                        
                        <defs>
                            <linearGradient id="seahorseGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#4de1f7"/>
                                <stop offset="50%" stop-color="#22b8d9"/>
                                <stop offset="100%" stop-color="#1894b8"/>
                            </linearGradient>
                            <linearGradient id="bellyGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#b6f4ff"/>
                                <stop offset="100%" stop-color="#6be3f7"/>
                            </linearGradient>
                        </defs>
                        
                        <!-- Dorsal Fin -->
                        <path d="M36 48 C28 42, 28 62, 38 65" fill="#58d9ef" opacity="0.8"/>
                        
                        <!-- Head Crest -->
                        <path d="M48 18 C46 12, 53 10, 56 16 C60 11, 67 13, 67 20" fill="url(#seahorseGrad)"/>
                        
                        <!-- Body -->
                        <path d="M50 20 C42 22, 38 28, 40 36 C41 40, 48 45, 52 46 C48 52, 46 62, 52 72 C56 78, 58 84, 52 90 C46 96, 42 90, 45 84 C46 82, 44 80, 42 82 C38 88, 42 102, 54 100 C64 98, 66 84, 60 74 C56 66, 56 58, 62 50 C68 42, 70 32, 62 24 C58 20, 54 20, 50 20 Z" fill="url(#seahorseGrad)"/>
                        
                        <!-- Snout -->
                        <path d="M42 28 C34 27, 28 30, 26 33 C26 36, 32 37, 40 35 Z" fill="url(#seahorseGrad)"/>
                        
                        <!-- Belly Segments -->
                        <path d="M44 48 C48 47, 56 50, 58 56 C50 56, 46 54, 44 48 Z" fill="url(#bellyGrad)"/>
                        <path d="M46 57 C50 56, 56 59, 57 65 C50 65, 47 62, 46 57 Z" fill="url(#bellyGrad)"/>
                        <path d="M48 66 C51 65, 55 67, 56 72 C51 72, 48 70, 48 66 Z" fill="url(#bellyGrad)"/>
                        
                        <!-- Eye -->
                        <circle cx="52" cy="27" r="3.5" fill="#ffffff"/>
                        <circle cx="52.5" cy="27" r="2" fill="#164e63"/>
                        <circle cx="53.5" cy="26" r="0.8" fill="#ffffff"/>
                        
                        <!-- Cheek Blush -->
                        <ellipse cx="46" cy="33" rx="2.5" ry="1.5" fill="#ff7da7" opacity="0.6"/>
                    </svg>
                </div>
                
                <div>
                    <h1 class="text-4xl font-black text-white tracking-wider drop-shadow-sm leading-none">SABARA</h1>
                    <p class="text-white text-xs font-semibold tracking-tight mt-1.5 opacity-95">sahabat bahasa daerah</p>
                </div>
            </div>
        </div>

        <!-- White Bottom Sheet Card -->
        <div class="bg-white rounded-t-[36px] px-8 pt-8 pb-10 shadow-2xl flex-1 flex flex-col justify-between">
            <div>
                <!-- Heading -->
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-7">Masuk</h2>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               placeholder="Alamat pos-el" 
                               class="w-full px-5 py-3.5 rounded-2xl border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#74C5E3] focus:ring-2 focus:ring-[#74C5E3]/20 transition text-sm bg-white" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                    </div>

                    <!-- Password Input -->
                    <div>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="Kata sandi" 
                               class="w-full px-5 py-3.5 rounded-2xl border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#74C5E3] focus:ring-2 focus:ring-[#74C5E3]/20 transition text-sm bg-white" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 px-4 bg-[#76C5E3] hover:bg-[#60B6D6] text-white font-bold rounded-2xl shadow-sm transition active:scale-[0.99] text-base">
                            Masuk
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="relative flex items-center justify-center my-6">
                        <div class="border-t border-gray-200 w-full"></div>
                        <span class="bg-white px-3 text-xs text-gray-400 font-medium">Cara lain</span>
                        <div class="border-t border-gray-200 w-full"></div>
                    </div>

                    <!-- Google Login Button -->
                    <button type="button" class="w-full py-3 px-4 border border-gray-200 rounded-2xl flex items-center justify-center gap-3 text-gray-700 font-semibold hover:bg-gray-50 shadow-sm transition text-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                            <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                            <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                            <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                        </svg>
                        <span>Masuk dengan akun Google</span>
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-[#76C5E3] hover:text-[#52AFD1] transition">Daftar sekarang</a>
            </div>
        </div>
    </div>
</x-guest-layout>
