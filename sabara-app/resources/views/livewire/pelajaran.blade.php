<div class="px-5 pt-6 pb-36 font-sans max-w-md mx-auto min-h-screen flex flex-col justify-between" x-data="{ currentAudio: null }">
    <div>
        <!-- Top Close Button -->
        <div class="flex items-center justify-between mb-4">
            <a href="/beranda" class="p-2 -ml-2 text-slate-800 hover:text-slate-600 rounded-full hover:bg-slate-100 transition">
                <svg class="w-6 h-6 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
            <div></div>
        </div>

        <!-- Mascot Illustration & Title -->
        <div class="flex flex-col items-center text-center mb-6">
            <!-- 2-Person Chatting Illustration -->
            <div class="w-24 h-24 relative mb-2 flex items-center justify-center">
                <svg viewBox="0 0 120 120" class="w-full h-full drop-shadow-xs" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Top Speech Bubbles -->
                    <rect x="25" y="14" width="38" height="22" rx="6" fill="#38BDF8" stroke="#0284C7" stroke-width="2.5"/>
                    <line x1="32" y1="21" x2="55" y2="21" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="32" y1="27" x2="48" y2="27" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M35 36 L30 43 L42 36 Z" fill="#38BDF8" stroke="#0284C7" stroke-width="2.5" stroke-linejoin="round"/>

                    <rect x="58" y="6" width="38" height="22" rx="6" fill="#2DD4BF" stroke="#0F766E" stroke-width="2.5"/>
                    <line x1="65" y1="13" x2="88" y2="13" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="65" y1="19" x2="80" y2="19" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M85 28 L90 35 L78 28 Z" fill="#2DD4BF" stroke="#0F766E" stroke-width="2.5" stroke-linejoin="round"/>

                    <!-- Boy Character (Left) -->
                    <!-- Hair -->
                    <path d="M30 65 C30 50, 52 48, 54 65 C54 75, 48 78, 30 75 Z" fill="#F59E0B" stroke="#78350F" stroke-width="2.5"/>
                    <!-- Face -->
                    <circle cx="42" cy="72" r="16" fill="#FDE68A" stroke="#78350F" stroke-width="2.5"/>
                    <!-- Eyes & Smile -->
                    <circle cx="37" cy="72" r="2" fill="#78350F"/>
                    <circle cx="47" cy="72" r="2" fill="#78350F"/>
                    <path d="M40 78 Q42 81 44 78" stroke="#78350F" stroke-width="2" fill="none" stroke-linecap="round"/>
                    <!-- Hair Front -->
                    <path d="M32 60 Q42 55 52 64" fill="#F59E0B" stroke="#78350F" stroke-width="2.5"/>

                    <!-- Girl Character (Right) -->
                    <!-- Hair Back -->
                    <path d="M68 62 C68 48, 92 48, 94 62 C96 78, 98 90, 88 88 C80 88, 70 82, 68 62 Z" fill="#334155" stroke="#0F172A" stroke-width="2.5"/>
                    <!-- Face -->
                    <circle cx="80" cy="72" r="16" fill="#FED7AA" stroke="#7C2D12" stroke-width="2.5"/>
                    <!-- Eyes & Smile -->
                    <circle cx="75" cy="72" r="2" fill="#7C2D12"/>
                    <circle cx="85" cy="72" r="2" fill="#7C2D12"/>
                    <path d="M78 78 Q80 81 82 78" stroke="#7C2D12" stroke-width="2" fill="none" stroke-linecap="round"/>
                    <!-- Hair Front -->
                    <path d="M68 60 Q76 56 86 63" fill="#334155" stroke="#0F172A" stroke-width="2.5"/>
                </svg>
            </div>

            <!-- Category Subtitle -->
            <p class="font-bold text-slate-800 text-sm sm:text-base leading-tight">
                {{ $materi->category ?? 'Dasar' }}
            </p>
            <!-- Title -->
            <h1 class="font-black text-xl sm:text-2xl text-slate-900 tracking-tight mt-0.5">
                {{ $materi->title }}
            </h1>
        </div>

        <!-- Chat Conversation Card Container -->
        <div class="bg-white rounded-[32px] border border-gray-100 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] p-5 sm:p-6 space-y-4">
            @forelse($percakapan as $dialog)
                @php
                    $isSpeaker1 = ($dialog->speaker == '1' || $dialog->speaker === 'Speaker 1' || $dialog->speaker === 'Penutur 1');
                @endphp

                @if($isSpeaker1)
                    <!-- Speaker 1 (Left - White Bubble) -->
                    <div class="flex justify-start">
                        <div class="bg-white border border-gray-200/80 rounded-2xl rounded-tl-sm p-4 shadow-xs max-w-[85%] relative group">
                            <p class="font-bold text-sm text-slate-900 leading-snug">
                                {{ $dialog->bengkulu }}
                            </p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">
                                {{ $dialog->indonesia }}
                            </p>
                            
                            @if($dialog->audio_url)
                                <button @click="if(currentAudio) currentAudio.pause(); currentAudio = new Audio('{{ $dialog->audio_url }}'); currentAudio.play()" 
                                        class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold text-[#2998BD] bg-[#DCF3FB] px-2 py-0.5 rounded-full hover:bg-[#cbeaf6] transition">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
                                    <span>Putar Suara</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @else
                    <!-- Speaker 2 (Right - Soft Light Blue Bubble) -->
                    <div class="flex justify-end">
                        <div class="bg-[#F0F8FC] border border-[#E0F0F8] rounded-2xl rounded-tr-sm p-4 shadow-xs max-w-[85%] relative group">
                            <p class="font-bold text-sm text-slate-900 leading-snug">
                                {{ $dialog->bengkulu }}
                            </p>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">
                                {{ $dialog->indonesia }}
                            </p>
                            
                            @if($dialog->audio_url)
                                <button @click="if(currentAudio) currentAudio.pause(); currentAudio = new Audio('{{ $dialog->audio_url }}'); currentAudio.play()" 
                                        class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold text-[#2998BD] bg-[#DCF3FB] px-2 py-0.5 rounded-full hover:bg-[#cbeaf6] transition">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
                                    <span>Putar Suara</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center py-8 text-slate-400">
                    <span class="text-3xl block mb-2">💬</span>
                    <p class="text-sm">Belum ada dialog percakapan untuk materi ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Bottom Action Button: Mulai Latihan -->
    <div class="mt-8">
        <a href="{{ route('latihan', ['categoryId' => $materiId, 'level' => (count($levels) > 0 ? $levels[0] : 1)]) }}" 
           class="w-full bg-[#9DE4C7] hover:bg-[#88DAB9] text-[#134E4A] font-black text-base py-4 px-6 rounded-2xl shadow-sm block text-center transition active:scale-[0.99]">
            Mulai Latihan
        </a>
    </div>
</div>
