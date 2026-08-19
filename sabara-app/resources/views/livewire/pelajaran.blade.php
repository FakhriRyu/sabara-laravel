<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header -->
    <div class="bg-green-600 text-white rounded-b-3xl p-6 shadow-md relative overflow-hidden">
        <div class="absolute top-0 right-0 opacity-10">
            <svg width="150" height="150" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L2 7l10 5 10-5-10-5zm0 7.5l-10-5v10l10 5 10-5v-10l-10 5z"/>
            </svg>
        </div>
        
        <div class="relative z-10 flex items-center mb-6">
            <a href="{{ route('beranda') }}" class="mr-4 p-2 bg-white/20 rounded-full hover:bg-white/30 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">{{ $materi->title }}</h1>
                <p class="text-green-100 text-sm opacity-90">{{ ucfirst($materi->category) }}</p>
            </div>
        </div>
        
        <div class="relative z-10">
            <p class="text-white/90 text-sm leading-relaxed">{{ $materi->description }}</p>
        </div>
    </div>

    <div class="p-4 max-w-lg mx-auto space-y-8 mt-4">
        
        <!-- Section 1: Percakapan -->
        @if(count($percakapan) > 0)
        <div>
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Dialog Interaktif
            </h2>
            
            <div class="bg-white rounded-2xl shadow-sm p-4 space-y-4" x-data="{ currentAudio: null }">
                @foreach($percakapan as $dialog)
                    @if($dialog->speaker === 'Speaker 1')
                        <div class="flex flex-col items-start">
                            <span class="text-xs text-gray-500 mb-1 ml-2 font-medium">{{ $dialog->speaker }}</span>
                            <div class="bg-green-100 text-green-900 rounded-2xl rounded-tl-none px-4 py-3 max-w-[85%] relative group">
                                <p class="font-semibold text-sm">{{ $dialog->bengkulu_text }}</p>
                                <p class="text-xs text-green-700/80 mt-1 italic">{{ $dialog->indonesia_text }}</p>
                                
                                @if($dialog->audio_url)
                                <button @click="if(currentAudio) currentAudio.pause(); currentAudio = new Audio('{{ Storage::url($dialog->audio_url) }}'); currentAudio.play()" 
                                        class="absolute -right-10 top-2 p-1.5 bg-green-50 text-green-600 rounded-full shadow-sm hover:bg-green-200 transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-end">
                            <span class="text-xs text-gray-500 mb-1 mr-2 font-medium">{{ $dialog->speaker }}</span>
                            <div class="bg-emerald-50 border border-emerald-100 text-emerald-900 rounded-2xl rounded-tr-none px-4 py-3 max-w-[85%] relative group">
                                <p class="font-semibold text-sm">{{ $dialog->bengkulu_text }}</p>
                                <p class="text-xs text-emerald-700/80 mt-1 italic">{{ $dialog->indonesia_text }}</p>
                                
                                @if($dialog->audio_url)
                                <button @click="if(currentAudio) currentAudio.pause(); currentAudio = new Audio('{{ Storage::url($dialog->audio_url) }}'); currentAudio.play()" 
                                        class="absolute -left-10 top-2 p-1.5 bg-emerald-50 text-emerald-600 rounded-full shadow-sm hover:bg-emerald-200 transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Section 2: Level Latihan -->
        <div>
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Latihan Pemahaman
            </h2>
            
            <div class="space-y-3">
                @forelse($levels as $level)
                    @php
                        $levelProgress = $progress[$level] ?? null;
                        $stars = $levelProgress ? $levelProgress['stars'] : 0;
                    @endphp
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Level {{ $level }}</h3>
                            <div class="flex items-center mt-1 space-x-1">
                                @for($i = 1; $i <= 3; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        
                        <a href="{{ route('latihan', ['categoryId' => $materiId, 'level' => $level]) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full font-semibold shadow-sm transition transform hover:scale-105 active:scale-95 text-sm">
                            Mulai
                        </a>
                    </div>
                @empty
                    <div class="bg-white p-6 rounded-xl shadow-sm text-center border border-gray-100">
                        <div class="text-gray-400 mb-2">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <p class="text-gray-500">Belum ada latihan untuk materi ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
