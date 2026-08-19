<div class="min-h-screen bg-[#B8EBF6] pb-36 font-sans select-none">
    <!-- Top Header Banner -->
    <div class="pt-5 px-4 max-w-md mx-auto">
        <div class="flex items-center justify-between mb-2">
            <a href="{{ route('pelajaran', $materiId) }}" class="p-2 -ml-2 text-slate-800 hover:text-slate-600 rounded-full transition">
                <svg class="w-6 h-6 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Peta Pembelajaran</span>
            <div class="w-6"></div>
        </div>

        <div class="bg-[#78C9E4] rounded-3xl p-5 shadow-xs border border-white/30 text-white">
            <p class="text-xs font-bold text-white/90">
                bagian 1
            </p>
            <h1 class="text-2xl font-black tracking-tight text-white mt-0.5">
                {{ $materi->title }}
            </h1>
        </div>
    </div>

    <!-- Stepping Stones / Duolingo-style Learning Path -->
    <div class="max-w-md mx-auto px-6 pt-10 pb-16 space-y-12 relative">
        
        <!-- Node 5: Latihan Akhir (Top Center) -->
        <div class="flex flex-col items-center justify-center relative z-10">
            <!-- Label Pill -->
            <div class="mb-2.5 px-3.5 py-1 bg-white/90 backdrop-blur-xs rounded-full shadow-xs inline-flex items-center gap-1.5 border border-white/60">
                <span class="text-xs font-extrabold text-slate-800">Latihan Akhir</span>
                <span class="text-xs font-black text-emerald-500">✓</span>
            </div>

            <!-- Big Golden Star Button -->
            <button wire:click="startLevel(5)" class="group relative active:scale-95 transition-all duration-200 cursor-pointer focus:outline-none">
                <div class="w-28 h-28 relative flex items-center justify-center filter drop-shadow-[0_8px_16px_rgba(234,179,8,0.35)] group-hover:scale-105 transition-transform">
                    <svg viewBox="0 0 100 100" class="w-full h-full" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="starGoldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#FDE047"/>
                                <stop offset="50%" stop-color="#F59E0B"/>
                                <stop offset="100%" stop-color="#D97706"/>
                            </linearGradient>
                            <linearGradient id="starBevel" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#FEF08A" stop-opacity="0.8"/>
                                <stop offset="100%" stop-color="#B45309" stop-opacity="0.6"/>
                            </linearGradient>
                        </defs>
                        <!-- 3D Star Shape -->
                        <path d="M50 8 L62 34 L90 38 L70 58 L75 86 L50 72 L25 86 L30 58 L10 38 L38 34 Z" 
                              fill="url(#starGoldGrad)" 
                              stroke="#FBBF24" 
                              stroke-width="2" 
                              stroke-linejoin="round"/>
                        <path d="M50 8 L62 34 L50 72 L38 34 Z" fill="url(#starBevel)" opacity="0.4"/>
                        <path d="M50 72 L70 58 L90 38 L62 34 Z" fill="#D97706" opacity="0.2"/>
                    </svg>
                </div>
            </button>
        </div>

        <!-- Node 4: Membaca (Left) -->
        <div class="flex flex-col items-start pl-8 relative z-10">
            <!-- Label Pill -->
            <div class="mb-2 px-3.5 py-1 bg-white/90 backdrop-blur-xs rounded-full shadow-xs inline-flex items-center gap-1.5 border border-white/60">
                <span class="text-xs font-extrabold text-slate-800">Membaca</span>
                <span class="text-xs font-black text-emerald-500">✓</span>
            </div>

            <!-- Circular Button (Book) -->
            <button wire:click="startLevel(4)" class="w-24 h-24 rounded-full bg-[#A2DCED] border-[3px] border-[#72C3DC] shadow-[0_6px_0_#62B2CB,0_10px_15px_rgba(0,0,0,0.06)] flex items-center justify-center active:translate-y-1 active:shadow-[0_2px_0_#62B2CB] transition-all cursor-pointer group">
                <svg class="w-12 h-12 text-slate-900 group-hover:scale-105 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </button>
        </div>

        <!-- Node 3: Percakapan (Right) -->
        <div class="flex flex-col items-end pr-8 relative z-10">
            <!-- Label Pill -->
            <div class="mb-2 px-3.5 py-1 bg-white/90 backdrop-blur-xs rounded-full shadow-xs inline-flex items-center gap-1.5 border border-white/60">
                <span class="text-xs font-extrabold text-slate-800">Percakapan</span>
                <span class="text-xs font-black text-emerald-500">✓</span>
            </div>

            <!-- Circular Button (Two People) -->
            <button wire:click="startLevel(3)" class="w-24 h-24 rounded-full bg-[#A2DCED] border-[3px] border-[#72C3DC] shadow-[0_6px_0_#62B2CB,0_10px_15px_rgba(0,0,0,0.06)] flex items-center justify-center active:translate-y-1 active:shadow-[0_2px_0_#62B2CB] transition-all cursor-pointer group">
                <svg class="w-12 h-12 text-slate-900 group-hover:scale-105 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 14c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-7 6c0-2.67 5.33-4 8-4s8 1.33 8 4v2H5v-2z" />
                    <circle cx="17" cy="8" r="2.5" />
                    <path d="M17 12c1.8 0 4.5.9 4.8 2.2.1.3.2.7.2 1.1v.7h-3v-1.8c0-.9-.7-1.7-2-2.2z" opacity="0.6"/>
                </svg>
            </button>
        </div>

        <!-- Node 2: Terjemahan (Left) -->
        <div class="flex flex-col items-start pl-8 relative z-10">
            <!-- Label Pill -->
            <div class="mb-2 px-3.5 py-1 bg-white/90 backdrop-blur-xs rounded-full shadow-xs inline-flex items-center gap-1.5 border border-white/60">
                <span class="text-xs font-extrabold text-slate-800">Terjemahan</span>
                <span class="text-xs font-black text-emerald-500">✓</span>
            </div>

            <!-- Circular Button (Translate 文A) -->
            <button wire:click="startLevel(2)" class="w-24 h-24 rounded-full bg-[#A2DCED] border-[3px] border-[#72C3DC] shadow-[0_6px_0_#62B2CB,0_10px_15px_rgba(0,0,0,0.06)] flex items-center justify-center active:translate-y-1 active:shadow-[0_2px_0_#62B2CB] transition-all cursor-pointer group">
                <div class="text-3xl font-black text-slate-900 leading-none group-hover:scale-105 transition-transform">
                    文<span class="text-2xl font-bold">A</span>
                </div>
            </button>
        </div>

        <!-- Node 1: Mendengarkan (Right) -->
        <div class="flex flex-col items-end pr-8 relative z-10">
            <!-- Label Pill -->
            <div class="mb-2 px-3.5 py-1 bg-white/90 backdrop-blur-xs rounded-full shadow-xs inline-flex items-center gap-1.5 border border-white/60">
                <span class="text-xs font-extrabold text-slate-800">Mendengarkan</span>
                <span class="text-xs font-black text-emerald-500">✓</span>
            </div>

            <!-- Circular Button (Headphones) -->
            <button wire:click="startLevel(1)" class="w-24 h-24 rounded-full bg-[#A2DCED] border-[3px] border-[#72C3DC] shadow-[0_6px_0_#62B2CB,0_10px_15px_rgba(0,0,0,0.06)] flex items-center justify-center active:translate-y-1 active:shadow-[0_2px_0_#62B2CB] transition-all cursor-pointer group">
                <svg class="w-12 h-12 text-slate-900 group-hover:scale-105 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 18v-6a9 9 0 0118 0v6M3 18a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3v5zm18 0a2 2 0 00-2 2h-1a2 2 0 00-2-2v-3a2 2 0 002-2h3v5z"/>
                </svg>
            </button>
        </div>
    </div>
</div>
