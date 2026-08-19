<div class="p-6 space-y-6 max-w-7xl mx-auto">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">Manajemen Materi</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola bab materi, percakapan, dan soal latihan interaktif</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold shadow-sm transition text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Materi Baru
        </button>
    </div>

    <!-- Flash Message -->
    @if(session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-semibold flex items-center gap-2">
            <span>✅</span> {{ session('message') }}
        </div>
    @endif

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center gap-4">
        <div class="relative flex-1 w-full">
            <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari judul materi atau kategori..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
        </div>
        <div class="w-full sm:w-64">
            <select wire:model.live="languageFilter" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-green-500">
                <option value="">Semua Bahasa</option>
                @foreach($languages as $lang)
                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-400 tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Materi</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Bahasa</th>
                        <th class="px-6 py-4 text-center">Konten</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($materis as $materi)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                                        @if($materi->icon)
                                            <img src="{{ $materi->icon }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xl">📚</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $materi->title }}</p>
                                        <p class="text-xs text-slate-400 line-clamp-1 max-w-xs">{{ $materi->description ?? 'Tidak ada deskripsi' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-semibold">
                                    {{ $materi->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $materi->language->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold border border-emerald-100">
                                        {{ $materi->percakapan_count }} Dialog
                                    </span>
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold border border-blue-100">
                                        {{ $materi->soal_latihan_count }} Soal
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.materi.detail', $materi->id) }}" class="px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                        <span>⚙️</span> Kelola Konten
                                    </a>
                                    <button wire:click="edit('{{ $materi->id }}')" class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button wire:click="delete('{{ $materi->id }}')" onclick="return confirm('Yakin ingin menghapus materi ini? Semua percakapan dan soal di dalamnya akan terhapus.') || event.stopImmediatePropagation()" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <span class="text-3xl block mb-2">📚</span>
                                Tidak ada data materi ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($materis->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $materis->links() }}
            </div>
        @endif
    </div>

    <!-- Create / Edit Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-6 relative animate-in fade-in zoom-in duration-200">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-900">
                    {{ $materiId ? 'Edit Materi' : 'Tambah Materi Baru' }}
                </h3>
                <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit="save" class="space-y-4">
                <!-- Bahasa -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Bahasa Daerah</label>
                    <select wire:model="language_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-green-500">
                        @foreach($languages as $lang)
                            <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                        @endforeach
                    </select>
                    @error('language_id') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Judul -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Judul Materi</label>
                    <input wire:model="title" type="text" placeholder="Contoh: Sapaan & Salam" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-green-500">
                    @error('title') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kategori</label>
                    <input wire:model="category" type="text" placeholder="Contoh: Percakapan Sehari-hari, Kosakata Dasar" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-green-500">
                    @error('category') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi (Opsional)</label>
                    <textarea wire:model="description" rows="3" placeholder="Penjelasan singkat mengenai materi ini..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-green-500"></textarea>
                    @error('description') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Icon Upload -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Icon / Gambar Sampul</label>
                    @if($existingIcon && !$icon)
                        <div class="mb-2 flex items-center gap-3">
                            <img src="{{ $existingIcon }}" class="w-12 h-12 rounded-xl object-cover border">
                            <span class="text-xs text-slate-400">Gambar saat ini</span>
                        </div>
                    @endif
                    <input wire:model="icon" type="file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    @error('icon') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Modal Actions -->
                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" wire:click="$set('showModal', false)" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-sm transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-sm shadow-md transition">
                        Simpan Materi
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
