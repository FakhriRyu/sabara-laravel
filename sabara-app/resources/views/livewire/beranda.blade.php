<div class="px-5 pt-8 pb-12 font-sans">
    <!-- Top Header -->
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Halo {{ $user->name }}!
            </h1>
            <p class="text-slate-500 text-sm font-medium mt-0.5">
                Mela kito lanjut belajar
            </p>
            <a href="/pilih-bahasa" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#DCF3FB] text-[#2998BD] rounded-full text-xs font-bold shadow-xs hover:bg-[#c9edf8] transition mt-2.5">
                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                    <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" />
                </svg>
                <span>{{ $user->selectedLanguage ? $user->selectedLanguage->name : 'Bahasa Bengkulu' }}</span>
                <svg class="w-3 h-3 text-[#2998BD] stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
        </div>

        <!-- Balai Bahasa Logo Badge -->
        <div class="w-14 h-14 rounded-full bg-white shadow-xs border border-sky-100 flex items-center justify-center p-1.5 shrink-0">
            <svg viewBox="0 0 60 60" class="w-full h-full" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="60" height="60" rx="30" fill="#F0F9FF"/>
                <!-- Stylized BB Logo -->
                <path d="M14 18 H26 C30 18, 33 21, 33 25 C33 27.5, 31 29.5, 29 30 C32 30.5, 34 33, 34 36 C34 40, 30 43, 25 43 H14 Z" fill="#38BDF8" fill-opacity="0.3" stroke="#0284C7" stroke-width="3" stroke-linejoin="round"/>
                <text x="32" y="22" font-size="6.5" font-weight="900" fill="#0369A1" font-family="sans-serif">Balai</text>
                <text x="32" y="30" font-size="6.5" font-weight="900" fill="#0369A1" font-family="sans-serif">Bahasa</text>
                <text x="32" y="37" font-size="5" font-weight="700" fill="#0284C7" font-family="sans-serif">Provinsi</text>
                <text x="32" y="44" font-size="5" font-weight="700" fill="#0284C7" font-family="sans-serif">Bengkulu</text>
            </svg>
        </div>
    </div>

    <!-- Stats Banner (Cream Card) -->
    <div class="bg-[#FAF6ED] border border-[#F2ECE0] rounded-[28px] p-5 shadow-xs mt-6 flex items-center justify-between">
        <!-- Rank -->
        <div class="flex items-center gap-3.5 pl-2">
            <div class="w-13 h-13 relative flex items-center justify-center shrink-0">
                <!-- 3D Golden Trophy SVG -->
                <svg viewBox="0 0 80 80" class="w-12 h-12 drop-shadow-sm" fill="none">
                    <defs>
                        <linearGradient id="goldGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#FDE047"/>
                            <stop offset="60%" stop-color="#EAB308"/>
                            <stop offset="100%" stop-color="#CA8A04"/>
                        </linearGradient>
                        <linearGradient id="baseGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#64748B"/>
                            <stop offset="100%" stop-color="#334155"/>
                        </linearGradient>
                    </defs>
                    <path d="M16 26 C8 26, 8 46, 22 48 M64 26 C72 26, 72 46, 58 48" stroke="#EAB308" stroke-width="5.5" fill="none" stroke-linecap="round"/>
                    <path d="M20 22 L60 22 C60 38, 52 52, 40 54 C28 52, 20 38, 20 22 Z" fill="url(#goldGrad1)"/>
                    <path d="M37 54 L43 54 L45 64 L35 64 Z" fill="#CA8A04"/>
                    <rect x="28" y="64" width="24" height="6" rx="2" fill="url(#baseGrad)"/>
                    <polygon points="40,28 43,35 50,35 45,40 47,47 40,42 33,47 35,40 30,35 37,35" fill="#FEF08A"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-black text-slate-900 leading-none tracking-tight">#{{ $rank }}</p>
                <p class="text-xs text-slate-500 font-semibold mt-1">Peringkat</p>
            </div>
        </div>

        <!-- Points -->
        <div class="flex items-center gap-3.5 pr-2">
            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-amber-500 to-amber-400 text-white flex items-center justify-center shadow-[0_4px_12px_rgba(245,158,11,0.35)] shrink-0">
                <svg class="w-7 h-7 fill-white" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-black text-slate-900 leading-none tracking-tight">{{ $totalPoints }}</p>
                <p class="text-xs text-slate-500 font-semibold mt-1">Poin</p>
            </div>
        </div>
    </div>

    <!-- Learning Materials Section -->
    <div class="mt-7 space-y-6">
        @php $counter = 0; @endphp
        @forelse($categories as $category)
            @foreach($category['items'] as $materi)
                @php $counter++; @endphp
                <a href="{{ route('pelajaran', ['materiId' => $materi['id']]) }}" class="block group">
                    <div class="rounded-[28px] overflow-hidden bg-white shadow-[0_6px_25px_-5px_rgba(0,0,0,0.07)] border border-gray-100 transition-all duration-300 group-hover:shadow-[0_10px_30px_-5px_rgba(0,0,0,0.12)] group-hover:-translate-y-0.5">
                        
                        <!-- Top Banner (Batik Bengkulu / Kaganga Floral Artwork) -->
                        <div class="h-44 w-full relative overflow-hidden bg-gradient-to-br from-amber-200 via-teal-300 to-emerald-400">
                            <!-- SVG Batik Pattern -->
                            <svg class="absolute inset-0 w-full h-full object-cover" viewBox="0 0 400 200" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="bgBatik{{ $counter }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#FCD34D"/>
                                        <stop offset="40%" stop-color="#F59E0B"/>
                                        <stop offset="70%" stop-color="#06B6D4"/>
                                        <stop offset="100%" stop-color="#0D9488"/>
                                    </linearGradient>
                                    <radialGradient id="flowerPetal{{ $counter }}" cx="50%" cy="50%" r="50%">
                                        <stop offset="0%" stop-color="#EF4444"/>
                                        <stop offset="70%" stop-color="#B91C1C"/>
                                        <stop offset="100%" stop-color="#7F1D1D"/>
                                    </radialGradient>
                                    <radialGradient id="flowerCenter{{ $counter }}" cx="50%" cy="50%" r="50%">
                                        <stop offset="0%" stop-color="#FEF08A"/>
                                        <stop offset="60%" stop-color="#F59E0B"/>
                                        <stop offset="100%" stop-color="#B45309"/>
                                    </radialGradient>
                                </defs>
                                
                                <rect width="400" height="200" fill="url(#bgBatik{{ $counter }})"/>
                                
                                <!-- Background Swirls & Kaganga Motifs -->
                                <g opacity="0.35" stroke="#FFFFFF" stroke-width="2.5" fill="none">
                                    <path d="M-20,100 Q40,20 100,80 T220,90 T340,60 T420,120"/>
                                    <path d="M0,150 Q80,90 160,160 T300,140 T420,180"/>
                                    <path d="M50,-20 Q120,60 200,20 T360,40"/>
                                    <circle cx="80" cy="40" r="18"/>
                                    <circle cx="320" cy="140" r="22"/>
                                    <circle cx="30" cy="160" r="15"/>
                                </g>

                                <!-- Left Flower -->
                                <g transform="translate(110, 160) scale(0.7)">
                                    <circle cx="0" cy="-35" r="22" fill="url(#flowerPetal{{ $counter }})"/>
                                    <circle cx="33" cy="-11" r="22" fill="url(#flowerPetal{{ $counter }})"/>
                                    <circle cx="21" cy="28" r="22" fill="url(#flowerPetal{{ $counter }})"/>
                                    <circle cx="-21" cy="28" r="22" fill="url(#flowerPetal{{ $counter }})"/>
                                    <circle cx="-33" cy="-11" r="22" fill="url(#flowerPetal{{ $counter }})"/>
                                    <circle cx="0" cy="0" r="20" fill="url(#flowerCenter{{ $counter }})" stroke="#78350F" stroke-width="3"/>
                                    <circle cx="0" cy="0" r="8" fill="#78350F"/>
                                </g>

                                <!-- Central Big Rafflesia / Bengkulu Floral Element -->
                                <g transform="translate(260, 100) scale(1.1)">
                                    <circle cx="0" cy="-40" r="26" fill="url(#flowerPetal{{ $counter }})" stroke="#FED7AA" stroke-width="2"/>
                                    <circle cx="38" cy="-12" r="26" fill="url(#flowerPetal{{ $counter }})" stroke="#FED7AA" stroke-width="2"/>
                                    <circle cx="24" cy="32" r="26" fill="url(#flowerPetal{{ $counter }})" stroke="#FED7AA" stroke-width="2"/>
                                    <circle cx="-24" cy="32" r="26" fill="url(#flowerPetal{{ $counter }})" stroke="#FED7AA" stroke-width="2"/>
                                    <circle cx="-38" cy="-12" r="26" fill="url(#flowerPetal{{ $counter }})" stroke="#FED7AA" stroke-width="2"/>
                                    <circle cx="0" cy="0" r="24" fill="url(#flowerCenter{{ $counter }})" stroke="#9A3412" stroke-width="4"/>
                                    <circle cx="0" cy="0" r="12" fill="#7C2D12"/>
                                    <circle cx="0" cy="0" r="5" fill="#FEF08A"/>
                                </g>

                                <!-- Top Right Flower -->
                                <g transform="translate(370, 40) scale(0.8)">
                                    <circle cx="0" cy="-30" r="20" fill="url(#flowerPetal{{ $counter }})"/>
                                    <circle cx="28" cy="-9" r="20" fill="url(#flowerPetal{{ $counter }})"/>
                                    <circle cx="18" cy="24" r="20" fill="url(#flowerPetal{{ $counter }})"/>
                                    <circle cx="-18" cy="24" r="20" fill="url(#flowerPetal{{ $counter }})"/>
                                    <circle cx="-28" cy="-9" r="20" fill="url(#flowerPetal{{ $counter }})"/>
                                    <circle cx="0" cy="0" r="18" fill="url(#flowerCenter{{ $counter }})" stroke="#78350F" stroke-width="2.5"/>
                                </g>

                                <!-- Leaves & Vines -->
                                <path d="M210,130 Q180,110 170,70 Q190,80 210,130 Z" fill="#14B8A6" opacity="0.85"/>
                                <path d="M300,70 Q320,50 340,30 Q330,60 300,70 Z" fill="#0D9488" opacity="0.85"/>
                            </svg>

                            <!-- Speech Bubble Tooltip -->
                            <div class="absolute left-6 top-10 z-10">
                                <div class="relative bg-white px-5 py-2.5 rounded-2xl shadow-lg border border-slate-100">
                                    <p class="font-bold text-slate-900 text-sm sm:text-base whitespace-nowrap">
                                        {{ $materi['title'] }}
                                    </p>
                                    <!-- Tail -->
                                    <div class="absolute -bottom-2 left-6 w-4 h-4 bg-white rotate-45 border-r border-b border-slate-100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Card Details -->
                        <div class="p-5 sm:px-6">
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">
                                BAGIAN {{ $counter }}
                            </p>

                            <div class="flex items-center gap-4">
                                <!-- Wide Progress Bar -->
                                <div class="flex-1 bg-[#E8EDF2] h-7 rounded-full overflow-hidden relative flex items-center justify-center p-0.5">
                                    <div class="absolute left-0 top-0 bottom-0 bg-[#38BDF8] rounded-full transition-all duration-500" 
                                         style="width: {{ $materi['progress'] }}%"></div>
                                    <span class="relative z-10 text-xs font-black {{ $materi['progress'] > 50 ? 'text-white' : 'text-slate-500' }}">
                                        {{ $materi['completedLevels'] }}/{{ $materi['totalLevels'] }}
                                    </span>
                                </div>

                                <!-- Trophy / Badge Icon -->
                                <div class="shrink-0">
                                    <svg class="w-8 h-8 {{ $materi['completedLevels'] >= $materi['totalLevels'] && $materi['totalLevels'] > 0 ? 'text-amber-400' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-4.284-3.888A4.902 4.902 0 0110 11a4.902 4.902 0 01-.716.112A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        @empty
            <div class="bg-white p-8 rounded-3xl border border-dashed border-slate-200 text-center text-slate-400">
                <span class="text-3xl block mb-2">📚</span>
                Belum ada materi pembelajaran untuk bahasa ini.
            </div>
        @endforelse
    </div>
</div>
