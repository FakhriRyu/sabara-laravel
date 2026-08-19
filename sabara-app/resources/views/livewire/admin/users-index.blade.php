<div>
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Pengguna</h2>
        <button wire:click="exportCsv" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg shadow-sm transition">
            Unduh CSV
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau email..." class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="w-full sm:w-48">
                <select wire:model.live="roleFilter" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="p-4 text-sm font-semibold text-gray-600">Nama & Email</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Role</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Bahasa Dipilih</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Tgl Bergabung</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="font-medium text-gray-800">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </td>
                            <td class="p-4">
                                @if($user->role === 'admin')
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">Admin</span>
                                @else
                                    <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-medium">User</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-gray-700">
                                {{ $user->selectedLanguage ? $user->selectedLanguage->name : '-' }}
                            </td>
                            <td class="p-4 text-sm text-gray-700">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="p-4 text-right">
                                @if($user->id !== auth()->id())
                                    <button 
                                        wire:click="toggleRole('{{ $user->id }}')" 
                                        wire:confirm="Yakin ingin mengubah role pengguna ini?" 
                                        class="text-blue-600 hover:text-blue-900 mx-1 text-sm">
                                        Ubah Role
                                    </button>
                                    <button 
                                        wire:click="deleteUser('{{ $user->id }}')" 
                                        wire:confirm="Yakin ingin menghapus pengguna ini?" 
                                        class="text-red-600 hover:text-red-900 mx-1 text-sm">
                                        Hapus
                                    </button>
                                @else
                                    <span class="text-xs text-gray-400 italic">Anda (Saat Ini)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
