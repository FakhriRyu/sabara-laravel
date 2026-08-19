<div>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Efek Suara</h2>
        <p class="text-gray-600 mt-1">Kelola audio untuk feedback pengguna dalam kuis dan latihan.</p>
    </div>

    @php
        $soundTypes = [
            'correct' => ['label' => 'Jawaban Benar', 'desc' => 'Dimainkan saat pengguna memilih jawaban yang benar.'],
            'wrong' => ['label' => 'Jawaban Salah', 'desc' => 'Dimainkan saat pengguna memilih jawaban yang salah.'],
            'complete' => ['label' => 'Latihan Selesai', 'desc' => 'Dimainkan saat pengguna menyelesaikan sesi latihan atau kuis.'],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($soundTypes as $type => $info)
            @php 
                $effect = $effects->get($type); 
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center 
                        @if($type == 'correct') bg-emerald-100 text-emerald-600 
                        @elseif($type == 'wrong') bg-red-100 text-red-600 
                        @else bg-blue-100 text-blue-600 @endif">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $info['label'] }}</h3>
                        <p class="text-xs text-gray-500 capitalize">Tipe: {{ $type }}</p>
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 mb-4 flex-grow">{{ $info['desc'] }}</p>

                @if($effect && $effect->audio_url)
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-500 mb-2">Pratinjau Saat Ini:</p>
                        <audio controls class="w-full h-10">
                            <source src="{{ asset($effect->audio_url) }}" type="audio/mpeg">
                            Browser Anda tidak mendukung elemen audio.
                        </audio>
                    </div>
                @else
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-dashed border-gray-300 text-center">
                        <p class="text-sm text-gray-500 italic">Belum ada audio diunggah.</p>
                    </div>
                @endif

                @if (session()->has("message_{$type}"))
                    <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-3 py-2 rounded text-sm">
                        {{ session("message_{$type}") }}
                    </div>
                @endif

                <form wire:submit.prevent="uploadSound('{{ $type }}')" class="mt-auto">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Audio Baru</label>
                    <div class="flex items-center gap-2">
                        <input type="file" wire:model="uploads.{{ $type }}" accept="audio/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-full focus:outline-none">
                        
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full shadow-sm text-sm font-medium transition" wire:loading.attr="disabled" wire:target="uploads.{{ $type }}, uploadSound('{{ $type }}')">
                            Simpan
                        </button>
                    </div>
                    @error("uploads.{$type}") <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="uploads.{{ $type }}" class="text-indigo-600 text-xs mt-2">Mengunggah...</div>
                </form>
            </div>
        @endforeach
    </div>
</div>
