<div class="p-6 space-y-6 max-w-7xl mx-auto">
    <!-- Back & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.materi') }}" class="p-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 bg-green-50 text-green-700 text-xs font-bold rounded-md border border-green-200">{{ $materi->category }}</span>
                    <span class="text-xs text-slate-400">• {{ $materi->language->name ?? '-' }}</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $materi->title }}</h1>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-semibold flex items-center gap-2">
            <span>✅</span> {{ session('message') }}
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-px">
        <button wire:click="$set('activeTab', 'percakapan')" class="px-5 py-3 font-bold text-sm rounded-t-xl transition border-b-2 flex items-center gap-2 {{ $activeTab === 'percakapan' ? 'border-green-600 text-green-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            <span>💬</span> Dialog Percakapan ({{ $materi->percakapan->count() }})
        </button>
        <button wire:click="$set('activeTab', 'soal')" class="px-5 py-3 font-bold text-sm rounded-t-xl transition border-b-2 flex items-center gap-2 {{ $activeTab === 'soal' ? 'border-green-600 text-green-700 bg-white shadow-sm' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            <span>✏️</span> Soal Latihan ({{ $materi->soalLatihan->count() }})
        </button>
    </div>

    <!-- TAB 1: PERCAKAPAN -->
    @if($activeTab === 'percakapan')
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Kelola urutan dialog antara Penutur 1 dan Penutur 2.</p>
                <button wire:click="createPercakapan" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-sm shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Dialog
                </button>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm divide-y divide-slate-100 overflow-hidden">
                @forelse($materi->percakapan as $p)
                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                        <div class="flex items-start gap-4 flex-1">
                            <!-- Speaker Badge -->
                            <div class="px-3 py-1.5 rounded-xl font-extrabold text-xs shrink-0 mt-0.5 {{ $p->speaker == '1' ? 'bg-sky-100 text-sky-800' : 'bg-emerald-100 text-emerald-800' }}">
                                Penutur {{ $p->speaker }}
                            </div>
                            <!-- Dialog Texts -->
                            <div class="space-y-1">
                                <p class="text-sm font-bold text-slate-800">{{ $p->bengkulu }}</p>
                                <p class="text-xs text-slate-500 italic">{{ $p->indonesia }}</p>
                                @if($p->audio_url)
                                    <audio controls class="h-7 w-48 mt-2" src="{{ $p->audio_url }}"></audio>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-1 shrink-0 self-end sm:self-center">
                            <button wire:click="movePercakapan('{{ $p->id }}', 'up')" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition" title="Pindah Ke Atas">
                                ⬆️
                            </button>
                            <button wire:click="movePercakapan('{{ $p->id }}', 'down')" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition" title="Pindah Ke Bawah">
                                ⬇️
                            </button>
                            <button wire:click="editPercakapan('{{ $p->id }}')" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button wire:click="deletePercakapan('{{ $p->id }}')" onclick="return confirm('Yakin ingin menghapus dialog ini?') || event.stopImmediatePropagation()" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400">
                        <span class="text-3xl block mb-2">💬</span>
                        Belum ada dialog percakapan. Klik "Tambah Dialog" untuk memulai.
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- TAB 2: SOAL LATIHAN -->
    @if($activeTab === 'soal')
        <div class="space-y-6">
            <div class="flex items-center justify-between gap-4">
                <p class="text-sm text-slate-500">Soal latihan dikelompokkan berdasarkan level bertingkat.</p>
                <div class="flex items-center gap-2">
                    <button wire:click="$set('showBulkModal', true)" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-sm transition">
                        📦 Bulk Import JSON
                    </button>
                    <button wire:click="createSoal" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-sm shadow-sm transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Soal
                    </button>
                </div>
            </div>

            @forelse($groupedSoal as $lvl => $soals)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden space-y-2">
                    <div class="bg-slate-50 px-6 py-3 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-extrabold text-sm text-slate-800 flex items-center gap-2">
                            <span>⭐</span> Level {{ $lvl }} ({{ count($soals) }} Soal)
                        </h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($soals as $s)
                            <div class="p-4 sm:px-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                                <div class="space-y-1 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded text-[11px] font-extrabold uppercase bg-slate-100 text-slate-600">
                                            {{ str_replace('_', ' ', $s->type) }}
                                        </span>
                                        <span class="text-xs text-amber-500 font-bold">
                                            {{ str_repeat('★', $s->star) }}
                                        </span>
                                    </div>
                                    <p class="font-bold text-slate-800 text-sm">{{ $s->question }}</p>
                                    <p class="text-xs text-green-700 font-medium">Jawaban: <span class="font-semibold">{{ $s->answer }}</span></p>
                                </div>

                                <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                                    <button wire:click="duplicateSoal('{{ $s->id }}')" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition" title="Duplikat">
                                        📑
                                    </button>
                                    <button wire:click="editSoal('{{ $s->id }}')" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button wire:click="deleteSoal('{{ $s->id }}')" onclick="return confirm('Yakin ingin menghapus soal ini?') || event.stopImmediatePropagation()" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-2xl border text-center text-slate-400">
                    <span class="text-3xl block mb-2">✏️</span>
                    Belum ada soal latihan pada materi ini. Klik "Tambah Soal" untuk membuat soal baru.
                </div>
            @endforelse
        </div>
    @endif

    <!-- PERCAKAPAN MODAL -->
    @if($showPercakapanModal)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4 relative animate-in fade-in zoom-in duration-200">
            <h3 class="text-lg font-bold text-slate-900 border-b pb-3">
                {{ $percakapanId ? 'Edit Dialog' : 'Tambah Dialog' }}
            </h3>

            <form wire:submit="savePercakapan" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Penutur (Speaker)</label>
                    <select wire:model="speaker" class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm">
                        <option value="1">Penutur 1 (Kiri)</option>
                        <option value="2">Penutur 2 (Kanan)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Teks Bahasa Daerah (Bengkulu)</label>
                    <textarea wire:model="bengkulu" rows="2" class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm" placeholder="Contoh: Apo kaba?"></textarea>
                    @error('bengkulu') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Terjemahan Bahasa Indonesia</label>
                    <textarea wire:model="indonesia" rows="2" class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm" placeholder="Contoh: Apa kabar?"></textarea>
                    @error('indonesia') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Audio Pengucapan (Opsional)</label>
                    <input wire:model="audio" type="file" accept="audio/*" class="w-full text-xs file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-green-50 file:text-green-700">
                    @error('audio') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="pt-3 flex items-center justify-end gap-2 border-t">
                    <button type="button" wire:click="$set('showPercakapanModal', false)" class="px-4 py-2 bg-slate-100 rounded-xl font-semibold text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white font-bold rounded-xl text-sm shadow">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- SOAL LATIHAN MODAL -->
    @if($showSoalModal)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-4 relative animate-in fade-in zoom-in duration-200">
            <h3 class="text-lg font-bold text-slate-900 border-b pb-3">
                {{ $soalId ? 'Edit Soal Latihan' : 'Tambah Soal Latihan' }}
            </h3>

            <form wire:submit="saveSoal" class="space-y-4">
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tipe Soal</label>
                        <select wire:model.live="questionType" class="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs">
                            <option value="multiple_choice">Pilihan Ganda</option>
                            <option value="matching">Matching (Pasangan)</option>
                            <option value="audio">Audio</option>
                            <option value="reading">Bacaan (Reading)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Level</label>
                        <input wire:model="level" type="number" min="1" class="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Bintang</label>
                        <select wire:model="star" class="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs">
                            <option value="1">★ 1</option>
                            <option value="2">★★ 2</option>
                            <option value="3">★★★ 3</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pertanyaan / Instruksi</label>
                    <textarea wire:model="question" rows="2" class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm" placeholder="Tuliskan pertanyaan..."></textarea>
                    @error('question') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Dynamic inputs based on Type -->
                @if($questionType === 'multiple_choice' || $questionType === 'audio' || $questionType === 'reading')
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase">Pilihan Jawaban</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input wire:model="mc_opt_a" type="text" placeholder="Pilihan A" class="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs">
                            <input wire:model="mc_opt_b" type="text" placeholder="Pilihan B" class="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs">
                            <input wire:model="mc_opt_c" type="text" placeholder="Pilihan C" class="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs">
                            <input wire:model="mc_opt_d" type="text" placeholder="Pilihan D" class="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mt-2 mb-1">Jawaban Benar</label>
                            <input wire:model="answer" type="text" placeholder="Tulis persis teks jawaban yang benar" class="w-full px-4 py-2 bg-slate-50 border rounded-xl text-xs">
                        </div>
                    </div>
                @elseif($questionType === 'matching')
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700 uppercase">Pasangan Kata (Indonesia ↔ Bengkulu)</label>
                            <button type="button" wire:click="addMatchingPair" class="text-xs text-green-600 font-bold">+ Tambah Pasangan</button>
                        </div>
                        @foreach($matchingPairs as $idx => $pair)
                            <div class="flex items-center gap-2">
                                <input wire:model="matchingPairs.{{ $idx }}.indonesia" type="text" placeholder="Indonesia" class="w-1/2 px-3 py-2 bg-slate-50 border rounded-xl text-xs">
                                <span>↔</span>
                                <input wire:model="matchingPairs.{{ $idx }}.bengkulu" type="text" placeholder="Bengkulu" class="w-1/2 px-3 py-2 bg-slate-50 border rounded-xl text-xs">
                                @if(count($matchingPairs) > 2)
                                    <button type="button" wire:click="removeMatchingPair({{ $idx }})" class="text-rose-500 text-xs">✕</button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($questionType === 'audio')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">File Audio</label>
                        <input wire:model="soalAudio" type="file" accept="audio/*" class="w-full text-xs file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-blue-50 file:text-blue-700">
                    </div>
                @endif

                <div class="pt-3 flex items-center justify-end gap-2 border-t">
                    <button type="button" wire:click="$set('showSoalModal', false)" class="px-4 py-2 bg-slate-100 rounded-xl font-semibold text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white font-bold rounded-xl text-sm shadow">Simpan Soal</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- BULK IMPORT MODAL -->
    @if($showBulkModal)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-4 relative animate-in fade-in zoom-in duration-200">
            <h3 class="text-lg font-bold text-slate-900 border-b pb-3">
                Bulk Import Soal (JSON)
            </h3>
            <p class="text-xs text-slate-500">Paste array JSON yang berisi data soal.</p>
            <textarea wire:model="bulkJson" rows="8" placeholder='[{"question":"...","options":["..."],"answer":"...","level":1,"star":1}]' class="w-full p-3 font-mono text-xs bg-slate-50 border rounded-xl"></textarea>
            @error('bulkJson') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
            <div class="pt-3 flex items-center justify-end gap-2 border-t">
                <button type="button" wire:click="$set('showBulkModal', false)" class="px-4 py-2 bg-slate-100 rounded-xl font-semibold text-sm">Batal</button>
                <button wire:click="importBulk" class="px-4 py-2 bg-green-600 text-white font-bold rounded-xl text-sm shadow">Impor Sekarang</button>
            </div>
        </div>
    </div>
    @endif
</div>
