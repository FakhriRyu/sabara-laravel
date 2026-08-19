<div class="px-5 pt-8 pb-12 font-sans max-w-md mx-auto">
    @if (!$isQuizActive && !$isComplete)
        <!-- HEADER -->
        <div class="flex items-center justify-between gap-4 mb-3">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Peringkat Pengguna
            </h1>

            <!-- Balai Bahasa Logo Badge -->
            <div class="w-13 h-13 rounded-full bg-white shadow-xs border border-sky-100 flex items-center justify-center p-1 shrink-0">
                <svg viewBox="0 0 60 60" class="w-11 h-11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="60" height="60" rx="30" fill="#F0F9FF"/>
                    <path d="M14 18 H26 C30 18, 33 21, 33 25 C33 27.5, 31 29.5, 29 30 C32 30.5, 34 33, 34 36 C34 40, 30 43, 25 43 H14 Z" fill="#38BDF8" fill-opacity="0.3" stroke="#0284C7" stroke-width="3" stroke-linejoin="round"/>
                    <text x="32" y="22" font-size="6.5" font-weight="900" fill="#0369A1" font-family="sans-serif">Balai</text>
                    <text x="32" y="30" font-size="6.5" font-weight="900" fill="#0369A1" font-family="sans-serif">Bahasa</text>
                    <text x="32" y="37" font-size="5" font-weight="700" fill="#0284C7" font-family="sans-serif">Provinsi</text>
                    <text x="32" y="44" font-size="5" font-weight="700" fill="#0284C7" font-family="sans-serif">Bengkulu</text>
                </svg>
            </div>
        </div>

        <!-- MAIN LEADERBOARD CARD -->
        <div class="bg-white rounded-[32px] p-6 sm:p-7 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] border border-gray-100 mt-4">
            
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-extrabold text-slate-900">
                    Papan Peringkat
                </h2>
                <button wire:click="startQuiz" class="px-3.5 py-1.5 bg-[#DCF3FB] hover:bg-[#c6ecf9] text-[#2998BD] text-xs font-bold rounded-full transition flex items-center gap-1.5 shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                    Mulai Kuis
                </button>
            </div>

            <!-- TOP 3 PODIUM (MEDALS WITH RIBBONS) -->
            <div class="grid grid-cols-3 gap-2 items-end justify-center mb-10 pt-2">
                
                <!-- 2ND PLACE (SILVER - LEFT) -->
                @php $user2 = $leaderboard[1] ?? null; @endphp
                <div class="flex flex-col items-center">
                    <!-- Ribbon Medal 2 -->
                    <div class="w-16 h-20 relative flex items-center justify-center mb-2">
                        <svg viewBox="0 0 80 100" class="w-full h-full drop-shadow-sm" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Green Ribbons -->
                            <path d="M28 45 L20 85 L32 75 L44 85 L38 45 Z" fill="#22C55E"/>
                            <path d="M42 45 L36 85 L48 75 L60 85 L52 45 Z" fill="#16A34A"/>
                            <!-- Silver Rosette Badge -->
                            <circle cx="40" cy="38" r="28" fill="#94A3B8"/>
                            <circle cx="40" cy="38" r="25" fill="#CBD5E1" stroke="#64748B" stroke-width="2" stroke-dasharray="3 3"/>
                            <circle cx="40" cy="38" r="17" fill="#F8FAFC"/>
                            <text x="40" y="45" font-size="20" font-weight="900" fill="#475569" text-anchor="middle" font-family="sans-serif">2</text>
                        </svg>
                    </div>
                    <p class="font-bold text-xs text-slate-800 text-center truncate w-24">
                        {{ $user2 ? $user2->name : 'Pemain 2' }}
                    </p>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">
                        {{ $user2 ? $user2->max_score : '0' }}p
                    </p>
                </div>

                <!-- 1ST PLACE (GOLD - CENTER) -->
                @php $user1 = $leaderboard[0] ?? null; @endphp
                <div class="flex flex-col items-center -translate-y-2">
                    <!-- Ribbon Medal 1 -->
                    <div class="w-20 h-24 relative flex items-center justify-center mb-2">
                        <svg viewBox="0 0 90 110" class="w-full h-full drop-shadow-md" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Blue Ribbons -->
                            <path d="M30 50 L20 95 L34 83 L48 95 L42 50 Z" fill="#3B82F6"/>
                            <path d="M48 50 L42 95 L56 83 L70 95 L60 50 Z" fill="#2563EB"/>
                            <!-- Gold Rosette Badge -->
                            <circle cx="45" cy="42" r="32" fill="#F59E0B"/>
                            <circle cx="45" cy="42" r="28" fill="#FBBF24" stroke="#D97706" stroke-width="2.5" stroke-dasharray="4 3"/>
                            <circle cx="45" cy="42" r="19" fill="#FFFBEB"/>
                            <text x="45" y="50" font-size="24" font-weight="900" fill="#B45309" text-anchor="middle" font-family="sans-serif">1</text>
                        </svg>
                    </div>
                    <p class="font-extrabold text-sm text-slate-900 text-center truncate w-28">
                        {{ $user1 ? $user1->name : 'Pemain 1' }}
                    </p>
                    <p class="text-xs text-slate-500 font-bold mt-0.5">
                        {{ $user1 ? $user1->max_score : '0' }}p
                    </p>
                </div>

                <!-- 3RD PLACE (BRONZE - RIGHT) -->
                @php $user3 = $leaderboard[2] ?? null; @endphp
                <div class="flex flex-col items-center">
                    <!-- Ribbon Medal 3 -->
                    <div class="w-16 h-20 relative flex items-center justify-center mb-2">
                        <svg viewBox="0 0 80 100" class="w-full h-full drop-shadow-sm" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Blue Ribbons -->
                            <path d="M28 45 L20 85 L32 75 L44 85 L38 45 Z" fill="#3B82F6"/>
                            <path d="M42 45 L36 85 L48 75 L60 85 L52 45 Z" fill="#2563EB"/>
                            <!-- Bronze Rosette Badge -->
                            <circle cx="40" cy="38" r="28" fill="#EA580C"/>
                            <circle cx="40" cy="38" r="25" fill="#FB923C" stroke="#C2410C" stroke-width="2" stroke-dasharray="3 3"/>
                            <circle cx="40" cy="38" r="17" fill="#FFF7ED"/>
                            <text x="40" y="45" font-size="20" font-weight="900" fill="#9A3412" text-anchor="middle" font-family="sans-serif">3</text>
                        </svg>
                    </div>
                    <p class="font-bold text-xs text-slate-800 text-center truncate w-24">
                        {{ $user3 ? $user3->name : 'Pemain 3' }}
                    </p>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">
                        {{ $user3 ? $user3->max_score : '0' }}p
                    </p>
                </div>
            </div>

            <!-- RANK LIST (4 - 20) -->
            <div class="space-y-4 pt-2 border-t border-slate-50">
                @php $otherUsers = $leaderboard->skip(3); @endphp
                @forelse($otherUsers as $index => $u)
                    <div class="flex items-center justify-between py-1 px-2 rounded-xl {{ Auth::id() == $u->id ? 'bg-[#DCF3FB]/50' : '' }}">
                        <p class="font-bold text-sm text-slate-800 truncate max-w-[220px]">
                            {{ $index + 4 }}. {{ $u->name }}
                        </p>
                        <p class="font-bold text-sm text-slate-600 shrink-0">
                            {{ $u->max_score }}p
                        </p>
                    </div>
                @empty
                    @if(count($leaderboard) <= 3)
                        <!-- Fallback list for demo preview when few users exist -->
                        <div class="space-y-3.5 text-sm text-slate-600">
                            <div class="flex justify-between items-center py-0.5">
                                <span class="font-semibold text-slate-700">4. Re Aldi</span>
                                <span class="font-bold text-slate-600">150p</span>
                            </div>
                            <div class="flex justify-between items-center py-0.5">
                                <span class="font-semibold text-slate-700">5. Bernard Otto</span>
                                <span class="font-bold text-slate-600">150p</span>
                            </div>
                            <div class="flex justify-between items-center py-0.5">
                                <span class="font-semibold text-slate-700">6. Arono Arono</span>
                                <span class="font-bold text-slate-600">150p</span>
                            </div>
                            <div class="flex justify-between items-center py-0.5">
                                <span class="font-semibold text-slate-700">7. aisyah nur fadhillah rinaldi</span>
                                <span class="font-bold text-slate-600">100p</span>
                            </div>
                            <div class="flex justify-between items-center py-0.5">
                                <span class="font-semibold text-slate-700">8. Fori Bungo</span>
                                <span class="font-bold text-slate-600">100p</span>
                            </div>
                            <div class="flex justify-between items-center py-0.5">
                                <span class="font-semibold text-slate-700">9. Monika Jelita</span>
                                <span class="font-bold text-slate-600">100p</span>
                            </div>
                            <div class="flex justify-between items-center py-0.5">
                                <span class="font-semibold text-slate-700">10. dea belajar</span>
                                <span class="font-bold text-slate-600">100p</span>
                            </div>
                        </div>
                    @endif
                @endforelse
            </div>
        </div>

    @elseif ($isQuizActive)
        <!-- ACTIVE QUIZ FLOW -->
        @if(isset($questions[$currentIndex]))
            @php $q = $questions[$currentIndex]; @endphp
            <div class="bg-white px-4 py-3 shadow-xs sticky top-0 z-10 flex items-center justify-between border-b rounded-2xl mb-4">
                <button wire:click="backToLeaderboard" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-100" onclick="return confirm('Keluar dari kuis?') || event.stopImmediatePropagation()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <div class="font-bold text-slate-800 text-sm">Soal {{ $currentIndex + 1 }} / {{ $totalQuestions }}</div>
                <div class="w-8"></div>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden mb-6">
                <div class="bg-[#38BDF8] h-full transition-all duration-300" style="width: {{ (($currentIndex + 1) / $totalQuestions) * 100 }}%"></div>
            </div>

            <!-- Question Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 mb-6 relative">
                <span class="inline-block bg-sky-50 text-sky-700 text-xs font-extrabold px-3 py-1 rounded-full border border-sky-100 mb-3">
                    {{ $q->difficulty ?? 'Kuis' }}
                </span>
                <p class="text-lg font-bold text-slate-900 leading-snug">{{ $q->question }}</p>
            </div>

            <!-- Options -->
            <div class="space-y-3">
                @php
                    $rawOptions = is_string($q->options) ? json_decode($q->options, true) : $q->options;
                    $optionsList = [];
                    if (is_array($rawOptions)) {
                        if (isset($rawOptions['a']) || isset($rawOptions['b'])) {
                            $optionsList = $rawOptions;
                        } else {
                            $keys = ['a', 'b', 'c', 'd'];
                            foreach ($rawOptions as $idx => $opt) {
                                $key = $keys[$idx] ?? (string)$idx;
                                $optionsList[$key] = $opt;
                            }
                        }
                    }
                    $correctAnswer = $q->answer ?? $q->correct_answer ?? '';
                @endphp

                @foreach($optionsList as $key => $option)
                    @if($option)
                        @php
                            $isThisSelected = (string)$selectedAnswer === (string)$key;
                            $isThisCorrect = strtolower(trim((string)$key)) === strtolower(trim((string)$correctAnswer)) || 
                                            strtolower(trim((string)$option)) === strtolower(trim((string)$correctAnswer));
                            
                            $btnClass = "bg-white border-2 border-slate-200 text-slate-700 hover:border-[#38BDF8]";
                            if ($isAnswered) {
                                if ($isThisCorrect) {
                                    $btnClass = "bg-emerald-50 border-2 border-emerald-500 text-emerald-800 font-bold";
                                } elseif ($isThisSelected) {
                                    $btnClass = "bg-rose-50 border-2 border-rose-500 text-rose-800";
                                } else {
                                    $btnClass = "bg-white border-2 border-slate-100 text-slate-400 opacity-50";
                                }
                            }
                        @endphp
                        
                        <button 
                            wire:click="submitAnswer('{{ $key }}')" 
                            class="w-full text-left p-4 rounded-2xl transition-all duration-200 font-medium text-sm flex items-center justify-between {{ $btnClass }}"
                            {{ $isAnswered ? 'disabled' : '' }}
                        >
                            <span>{{ $option }}</span>
                            @if($isAnswered)
                                @if($isThisCorrect)
                                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                @elseif($isThisSelected)
                                    <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                                @endif
                            @endif
                        </button>
                    @endif
                @endforeach
            </div>

            <!-- Next Button -->
            @if($isAnswered)
            <div class="fixed bottom-0 left-0 right-0 p-4 bg-white/95 backdrop-blur border-t border-slate-100 max-w-md mx-auto pb-8 z-50">
                <button wire:click="nextQuestion" class="w-full bg-[#2998BD] hover:bg-[#207a97] text-white font-bold py-3.5 rounded-2xl shadow-md transition active:scale-[0.99] text-base">
                    {{ $currentIndex + 1 >= $totalQuestions ? 'Lihat Hasil' : 'Lanjut' }}
                </button>
            </div>
            @endif
        @endif

    @elseif ($isComplete)
        <!-- SUMMARY VIEW -->
        <div class="flex flex-col items-center justify-center min-h-[70vh] text-center pt-8">
            <div class="w-full bg-white rounded-[32px] p-8 shadow-sm border border-slate-100 space-y-6">
                <div class="text-6xl">🎉</div>
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Kuis Selesai!</h2>
                    <p class="text-slate-500 text-sm mt-1">Skor Kamu Berhasil Ditambahkan ke Papan Peringkat</p>
                </div>

                <div class="grid grid-cols-2 gap-3 py-4">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <p class="text-xs text-slate-400 font-bold uppercase">Total Skor</p>
                        <p class="text-3xl font-black text-[#2998BD] mt-1">{{ $score }}p</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <p class="text-xs text-slate-400 font-bold uppercase">Benar</p>
                        <p class="text-3xl font-black text-slate-800 mt-1">{{ $score / 10 }}<span class="text-base text-slate-400">/{{ $totalQuestions }}</span></p>
                    </div>
                </div>

                <div class="space-y-3">
                    <button wire:click="startQuiz" class="w-full bg-[#2998BD] hover:bg-[#207a97] text-white font-bold py-3.5 rounded-2xl shadow-sm transition">
                        Main Lagi
                    </button>
                    <button wire:click="backToLeaderboard" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 rounded-2xl transition">
                        Kembali ke Papan Peringkat
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
