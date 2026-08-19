<div class="min-h-screen bg-gray-50 flex flex-col" x-data="latihanAudio()">
    
    <!-- Top bar -->
    <div class="bg-white px-4 py-3 shadow-sm flex items-center justify-between border-b border-gray-100 shrink-0">
        <a href="{{ route('pelajaran.path', ['materiId' => $categoryId]) }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
        
        <!-- Progress Bar -->
        @if(!$isComplete && count($soalList) > 0)
        <div class="flex-1 mx-6">
            <div class="h-2.5 w-full bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 transition-all duration-500 ease-out" 
                     style="width: {{ ($currentIndex / count($soalList)) * 100 }}%"></div>
            </div>
        </div>
        <div class="text-sm font-bold text-gray-500">
            {{ $currentIndex + 1 }} / {{ count($soalList) }}
        </div>
        @else
        <div class="flex-1"></div>
        @endif
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-4 flex flex-col max-w-lg mx-auto w-full relative">
        
        @if($isComplete)
            <!-- Completion Screen -->
            <div class="flex-1 flex flex-col items-center justify-center text-center space-y-6 py-10"
                 x-init="playCompleteSound()">
                
                <div class="relative">
                    <svg class="w-32 h-32 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <!-- Stars -->
                    <div class="flex justify-center space-x-2 mt-4">
                        @for($i = 1; $i <= 3; $i++)
                            <svg class="w-10 h-10 {{ $i <= $stars ? 'text-yellow-400 drop-shadow-md' : 'text-gray-200' }} transform transition-all duration-500 delay-{{ $i * 200 }}" 
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Latihan Selesai!</h2>
                    <p class="text-gray-500 mt-2">Skor Kamu: <span class="font-bold text-green-600 text-xl">{{ $score }} / {{ count($soalList) }}</span></p>
                </div>

                <div class="w-full space-y-3 pt-6">
                    <a href="{{ route('latihan', ['categoryId' => $categoryId, 'level' => $level]) }}" 
                       class="block w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold shadow-md transition text-center">
                        Ulangi Latihan
                    </a>
                    <a href="{{ route('pelajaran.path', ['materiId' => $categoryId]) }}" 
                       class="block w-full py-3 px-4 bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl font-bold transition text-center">
                        Kembali ke Peta Belajar
                    </a>
                </div>
            </div>
            
        @elseif(count($soalList) === 0)
            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center text-center">
                <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-lg font-bold text-gray-700">Belum ada soal</h3>
                <p class="text-gray-500 mt-2 mb-6">Soal untuk level ini belum ditambahkan.</p>
                <a href="{{ route('pelajaran.path', ['materiId' => $categoryId]) }}" class="px-6 py-2 bg-[#2998BD] text-white rounded-full font-semibold shadow">
                    Kembali ke Peta Belajar
                </a>
            </div>
            
        @else
            <!-- Question Content -->
            @php 
                $soal = $soalList[$currentIndex]; 
                $options = is_string($soal['options']) ? json_decode($soal['options'], true) : $soal['options'];
            @endphp
            
            <div class="flex-1 flex flex-col mt-4">
                <!-- Question Type Header & Question Text -->
                <div class="mb-8">
                    @if($soal['type'] === 'reading')
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6 max-h-48 overflow-y-auto">
                            <p class="text-gray-700 leading-relaxed text-sm">
                                <!-- Assumes reading passage is stored in some way, or options/question has it -->
                                {!! nl2br(e($soal['question_text'])) !!}
                            </p>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Apa jawaban yang tepat?</h2>
                    
                    @elseif($soal['type'] === 'audio')
                        <div class="flex flex-col items-center justify-center py-6 mb-4 bg-white rounded-2xl shadow-sm border border-gray-100">
                            <button @click="playAudio('{{ Storage::url($soal['audio_url'] ?? '') }}')" 
                                    class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center hover:bg-green-200 transition mb-4 shadow-inner">
                                <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <h2 class="text-xl font-bold text-gray-800 text-center">{{ $soal['question_text'] }}</h2>
                        </div>
                        
                    @else
                        <h2 class="text-2xl font-bold text-gray-800">{{ $soal['question_text'] }}</h2>
                    @endif
                </div>

                <!-- Options -->
                <div class="space-y-3">
                    @if(is_array($options))
                        @foreach($options as $option)
                            @php
                                // If array, might be a text option or complex
                                $optionText = is_array($option) ? ($option['text'] ?? json_encode($option)) : $option;
                                
                                $isThisSelected = $selectedAnswer === $optionText;
                                
                                $buttonClass = "w-full text-left p-4 rounded-xl border-2 transition-all duration-200 font-semibold text-lg flex items-center justify-between";
                                
                                if (!$isAnswered) {
                                    $buttonClass .= " bg-white border-gray-200 text-gray-700 hover:border-green-400 hover:bg-green-50";
                                } else {
                                    if ($optionText === $soal['correct_answer']) {
                                        // Correct answer always turns green when answered
                                        $buttonClass .= " bg-green-100 border-green-500 text-green-800";
                                    } elseif ($isThisSelected) {
                                        // Wrong selection turns red
                                        $buttonClass .= " bg-red-100 border-red-500 text-red-800";
                                    } else {
                                        // Others fade out
                                        $buttonClass .= " bg-white border-gray-100 text-gray-400 opacity-50";
                                    }
                                }
                            @endphp
                            
                            <button 
                                wire:click="checkAnswer('{{ addslashes($optionText) }}')"
                                @if($isAnswered) disabled @endif
                                class="{{ $buttonClass }}">
                                
                                <span>{{ $optionText }}</span>
                                
                                @if($isAnswered && $optionText === $soal['correct_answer'])
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif($isAnswered && $isThisSelected)
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @endif
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Bottom Action Bar (shows when answered) -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t p-4 transition-transform duration-300 z-50 transform {{ $isAnswered ? 'translate-y-0' : 'translate-y-full' }}">
                <div class="max-w-lg mx-auto flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $isCorrect ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            @if($isCorrect)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-lg {{ $isCorrect ? 'text-green-600' : 'text-red-600' }}">
                                {{ $isCorrect ? 'Luar Biasa!' : 'Tetap Semangat!' }}
                            </h4>
                        </div>
                    </div>
                    
                    <button wire:click="nextQuestion" class="px-8 py-3 {{ $isCorrect ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white rounded-xl font-bold shadow-md transition">
                        Lanjut
                    </button>
                </div>
            </div>
            
            <!-- Padding for bottom bar so content isn't hidden -->
            @if($isAnswered)
                <div class="h-24 shrink-0"></div>
            @endif
            
        @endif
    </div>

    <!-- Hidden audio elements for SFX -->
    <audio id="sfx-correct" src="https://assets.mixkit.co/active_storage/sfx/2000/2000-preview.mp3"></audio>
    <audio id="sfx-wrong" src="https://assets.mixkit.co/active_storage/sfx/2003/2003-preview.mp3"></audio>
    <audio id="sfx-complete" src="https://assets.mixkit.co/active_storage/sfx/2018/2018-preview.mp3"></audio>

</div>

<script>
    function latihanAudio() {
        return {
            currentAudio: null,
            init() {
                // Listen to Livewire events
                window.addEventListener('play-sound', event => {
                    const type = event.detail.type;
                    const audio = document.getElementById('sfx-' + type);
                    if (audio) {
                        audio.currentTime = 0;
                        audio.play().catch(e => console.log('Audio play failed', e));
                    }
                });
            },
            playAudio(url) {
                if (!url) return;
                if (this.currentAudio) {
                    this.currentAudio.pause();
                }
                this.currentAudio = new Audio(url);
                this.currentAudio.play();
            },
            playCompleteSound() {
                const audio = document.getElementById('sfx-complete');
                if (audio) {
                    audio.currentTime = 0;
                    audio.play().catch(e => console.log('Audio play failed', e));
                }
            }
        }
    }
</script>
