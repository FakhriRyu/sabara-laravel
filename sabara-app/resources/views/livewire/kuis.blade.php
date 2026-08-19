<div class="max-w-md mx-auto bg-gray-50 min-h-screen pb-24 font-sans">
    @if (!$isQuizActive && !$isComplete)
        <!-- LEADERBOARD VIEW -->
        <div class="bg-green-600 text-white p-6 rounded-b-3xl shadow-md">
            <h1 class="text-2xl font-bold text-center">Kuis Bahasa Daerah</h1>
            <p class="text-center text-green-100 text-sm mt-1">Uji kemampuan dan raih skor tertinggi!</p>
        </div>

        <div class="px-4 mt-6">
            @if(count($leaderboard) > 0)
                <!-- Podium Top 3 -->
                <div class="flex justify-center items-end gap-2 mb-8 mt-4">
                    <!-- 2nd -->
                    @if(isset($leaderboard[1]))
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full bg-gray-200 border-4 border-gray-300 overflow-hidden mb-2 shadow-md">
                            <img src="{{ $leaderboard[1]->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($leaderboard[1]->name).'&color=7F9CF5&background=EBF4FF' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="bg-gray-300 text-gray-700 text-xs font-bold px-2 py-1 rounded-full mb-1">2nd</div>
                        <p class="text-xs font-semibold truncate w-20 text-center">{{ $leaderboard[1]->name }}</p>
                        <p class="text-xs text-gray-500">{{ $leaderboard[1]->max_score }} pts</p>
                        <div class="w-16 h-16 bg-gradient-to-t from-gray-300 to-gray-100 rounded-t-lg mt-2"></div>
                    </div>
                    @endif

                    <!-- 1st -->
                    @if(isset($leaderboard[0]))
                    <div class="flex flex-col items-center z-10">
                        <div class="text-2xl mb-1">👑</div>
                        <div class="w-20 h-20 rounded-full bg-yellow-200 border-4 border-yellow-400 overflow-hidden mb-2 shadow-lg">
                            <img src="{{ $leaderboard[0]->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($leaderboard[0]->name).'&color=D69E2E&background=FEFCBF' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded-full mb-1">1st</div>
                        <p class="text-sm font-bold truncate w-24 text-center">{{ $leaderboard[0]->name }}</p>
                        <p class="text-xs text-gray-500 font-semibold">{{ $leaderboard[0]->max_score }} pts</p>
                        <div class="w-20 h-24 bg-gradient-to-t from-yellow-400 to-yellow-200 rounded-t-lg mt-2"></div>
                    </div>
                    @endif

                    <!-- 3rd -->
                    @if(isset($leaderboard[2]))
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full bg-orange-200 border-4 border-orange-300 overflow-hidden mb-2 shadow-md">
                            <img src="{{ $leaderboard[2]->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($leaderboard[2]->name).'&color=DD6B20&background=FEEBC8' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="bg-orange-300 text-orange-800 text-xs font-bold px-2 py-1 rounded-full mb-1">3rd</div>
                        <p class="text-xs font-semibold truncate w-20 text-center">{{ $leaderboard[2]->name }}</p>
                        <p class="text-xs text-gray-500">{{ $leaderboard[2]->max_score }} pts</p>
                        <div class="w-16 h-12 bg-gradient-to-t from-orange-300 to-orange-100 rounded-t-lg mt-2"></div>
                    </div>
                    @endif
                </div>

                <!-- Others (4 - 20) -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-8">
                    <h3 class="text-sm font-semibold text-gray-500 mb-3 uppercase tracking-wider">Peringkat Lainnya</h3>
                    <div class="space-y-3">
                        @foreach($leaderboard->skip(3) as $index => $user)
                        <div class="flex items-center p-2 rounded-xl {{ Auth::id() == $user->id ? 'bg-green-50 border border-green-200' : '' }}">
                            <div class="w-8 text-center font-bold text-gray-400">#{{ $index + 4 }}</div>
                            <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="w-10 h-10 rounded-full mx-3">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                            </div>
                            <div class="font-bold text-green-600">{{ $user->max_score }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white p-8 rounded-2xl text-center shadow-sm border border-gray-100 mb-8 mt-4">
                    <div class="text-4xl mb-3">🏆</div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Belum ada peringkat</h3>
                    <p class="text-sm text-gray-500">Jadilah yang pertama untuk memimpin papan peringkat!</p>
                </div>
            @endif
        </div>

        <!-- Floating CTA -->
        <div class="fixed bottom-20 left-0 right-0 px-4 max-w-md mx-auto z-20">
            <button wire:click="startQuiz" class="w-full bg-green-600 text-white font-bold py-4 rounded-2xl shadow-lg hover:bg-green-700 transition active:scale-95 flex justify-center items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Mulai Kuis
            </button>
        </div>

    @elseif ($isQuizActive)
        <!-- ACTIVE QUIZ VIEW -->
        @if(isset($questions[$currentIndex]))
            @php $q = $questions[$currentIndex]; @endphp
            <div class="bg-white px-4 py-4 shadow-sm sticky top-0 z-10 flex items-center justify-between">
                <button wire:click="backToLeaderboard" class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100" onclick="return confirm('Yakin ingin keluar? Progres kuis tidak akan disimpan.') || event.stopImmediatePropagation()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <div class="font-bold text-gray-700">Pertanyaan {{ $currentIndex + 1 }} / {{ $totalQuestions }}</div>
                <div class="w-10"></div> <!-- spacing -->
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-gray-200 h-1">
                <div class="bg-green-600 h-1 transition-all duration-300" style="width: {{ (($currentIndex + 1) / $totalQuestions) * 100 }}%"></div>
            </div>

            <div class="p-4 mt-4">
                <!-- Question Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6 relative">
                    <span class="absolute -top-3 left-6 bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full border border-green-200">
                        {{ $q->difficulty ?? 'Soal' }}
                    </span>
                    <p class="text-lg font-medium text-gray-800 mt-2">{{ $q->question }}</p>
                </div>

                <!-- Options -->
                <div class="space-y-3">
                    @foreach(['a' => $q->option_a, 'b' => $q->option_b, 'c' => $q->option_c, 'd' => $q->option_d] as $key => $option)
                        @if($option)
                            @php
                                $isThisSelected = $selectedAnswer === $key;
                                $isThisCorrect = (string)$key === (string)$q->correct_answer;
                                
                                $btnClass = "bg-white border-2 border-gray-200 text-gray-700 hover:border-green-300";
                                if ($isAnswered) {
                                    if ($isThisCorrect) {
                                        $btnClass = "bg-green-50 border-2 border-green-500 text-green-800 font-bold";
                                    } elseif ($isThisSelected) {
                                        $btnClass = "bg-red-50 border-2 border-red-500 text-red-800";
                                    } else {
                                        $btnClass = "bg-white border-2 border-gray-200 text-gray-400 opacity-60";
                                    }
                                }
                            @endphp
                            
                            <button 
                                wire:click="submitAnswer('{{ $key }}')" 
                                class="w-full text-left p-4 rounded-xl transition-all duration-200 {{ $btnClass }}"
                                {{ $isAnswered ? 'disabled' : '' }}
                            >
                                <div class="flex justify-between items-center">
                                    <span>{{ $option }}</span>
                                    @if($isAnswered)
                                        @if($isThisCorrect)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        @elseif($isThisSelected)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        @endif
                                    @endif
                                </div>
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Next Button -->
            @if($isAnswered)
            <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-gray-100 max-w-md mx-auto pb-8 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="font-bold {{ $isCorrect ? 'text-green-600' : 'text-red-600' }}">
                        {{ $isCorrect ? 'Jawaban Benar!' : 'Jawaban Salah!' }}
                    </div>
                </div>
                <button wire:click="nextQuestion" class="w-full bg-green-600 text-white font-bold py-3.5 rounded-xl shadow-md hover:bg-green-700 transition active:scale-95">
                    {{ $currentIndex + 1 >= $totalQuestions ? 'Selesai' : 'Lanjut' }}
                </button>
            </div>
            @endif

        @endif

    @elseif ($isComplete)
        <!-- COMPLETE VIEW -->
        <div class="flex flex-col items-center justify-center min-h-[80vh] px-4 pt-10">
            <div class="w-full bg-white rounded-3xl p-8 shadow-sm border border-gray-100 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-32 bg-green-50"></div>
                
                <div class="relative z-10">
                    <div class="text-6xl mb-4">🎉</div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Kuis Selesai!</h2>
                    <p class="text-gray-500 mb-8">Kerja bagus! Berikut adalah hasilmu:</p>
                    
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                            <p class="text-sm text-gray-500 mb-1">Total Skor</p>
                            <p class="text-3xl font-black text-green-600">{{ $score }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                            <p class="text-sm text-gray-500 mb-1">Benar</p>
                            <p class="text-3xl font-black text-gray-800">{{ $score / 10 }}<span class="text-lg text-gray-400">/{{ $totalQuestions }}</span></p>
                        </div>
                    </div>
                    
                    @if($score > 0 && count($leaderboard) > 0 && Auth::check())
                        @php
                            $userMax = $leaderboard->where('id', Auth::id())->first();
                            $isNewBest = !$userMax || $score > $userMax->max_score;
                        @endphp
                        @if($isNewBest)
                        <div class="bg-yellow-50 text-yellow-800 border border-yellow-200 px-4 py-2 rounded-lg text-sm font-bold flex justify-center items-center gap-2 mb-8 animate-pulse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-4.284-3.888A4.902 4.902 0 0110 11a4.902 4.902 0 01-.716.112A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd" /></svg>
                            Skor Terbaik Baru!
                        </div>
                        @endif
                    @endif
                    
                    <div class="space-y-3">
                        <button wire:click="startQuiz" class="w-full bg-green-600 text-white font-bold py-3.5 rounded-xl shadow-md hover:bg-green-700 transition active:scale-95">
                            Main Lagi
                        </button>
                        <button wire:click="backToLeaderboard" class="w-full bg-white text-gray-700 font-bold py-3.5 rounded-xl shadow-sm border border-gray-200 hover:bg-gray-50 transition active:scale-95">
                            Lihat Peringkat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
