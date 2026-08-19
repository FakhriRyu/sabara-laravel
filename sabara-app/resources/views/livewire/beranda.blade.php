<div>
    <!-- Header Section -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-b-3xl px-6 pt-10 pb-24 text-white relative shadow-md">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white/50 bg-green-200 shrink-0">
                @if($user->avatar_url)
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-full h-full text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                @endif
            </div>
            <div>
                <h2 class="text-xl font-bold leading-tight">Halo, {{ explode(' ', $user->name)[0] }}!</h2>
                <div class="inline-flex items-center px-2 py-0.5 rounded-full bg-white/20 text-xs font-medium mt-1">
                    <span class="mr-1">🇮🇩</span> {{ $user->selectedLanguage ? $user->selectedLanguage->name : 'Bahasa belum dipilih' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="px-6 -mt-14 relative z-10">
        <div class="flex space-x-4">
            <div class="flex-1 bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center mb-2">
                    <span class="text-xl">🏆</span>
                </div>
                <p class="text-xs text-gray-500 font-medium">Ranking</p>
                <p class="text-lg font-bold text-gray-800">#{{ $rank }}</p>
            </div>
            
            <div class="flex-1 bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mb-2">
                    <span class="text-xl">⭐</span>
                </div>
                <p class="text-xs text-gray-500 font-medium">Total Poin</p>
                <p class="text-lg font-bold text-gray-800">{{ number_format($totalPoints) }}</p>
            </div>
        </div>
    </div>

    <!-- Materi Section -->
    <div id="materi" class="px-6 mt-8 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Materi Pembelajaran</h3>
        
        @if(empty($categories))
            <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-100">
                <p class="text-gray-500">Belum ada materi tersedia untuk bahasa ini.</p>
            </div>
        @else
            @foreach($categories as $category)
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">{{ $category['name'] }}</h4>
                    
                    <div class="space-y-3">
                        @foreach($category['items'] as $materi)
                            <a wire:navigate href="/pelajaran/{{ $materi['id'] }}" class="block bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:border-green-300 transition-colors">
                                <div class="flex items-start">
                                    <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-2xl mr-4 shrink-0">
                                        {{ $materi['icon'] ?? '📚' }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-base font-bold text-gray-800 truncate">{{ $materi['title'] }}</h5>
                                        <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $materi['description'] }}</p>
                                        
                                        <div class="mt-3 flex items-center justify-between">
                                            <div class="w-full bg-gray-100 rounded-full h-2.5 mr-3">
                                                <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $materi['progress'] }}%"></div>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-700 whitespace-nowrap">{{ $materi['completedLevels'] }}/{{ $materi['totalLevels'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
