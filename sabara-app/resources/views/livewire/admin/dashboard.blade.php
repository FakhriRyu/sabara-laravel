<div class="p-6 space-y-8 max-w-7xl mx-auto">
    <!-- Header Title -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">Dashboard Administrator</h1>
            <p class="text-slate-500 text-sm mt-1">Ringkasan statistik dan manajemen konten SABARA</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.materi') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold shadow-sm transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Materi
            </a>
            <a href="{{ route('admin.kuis') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-semibold shadow-sm transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Soal Kuis
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Materi -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Materi</p>
                <p class="text-3xl font-black text-slate-800 mt-2">{{ $totalMateri }}</p>
                <p class="text-xs text-green-600 mt-1 font-medium">{{ $totalLanguages }} Bahasa Aktif</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl shadow-inner">
                📚
            </div>
        </div>

        <!-- Soal Latihan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Soal Latihan</p>
                <p class="text-3xl font-black text-slate-800 mt-2">{{ $totalSoalLatihan }}</p>
                <p class="text-xs text-blue-600 mt-1 font-medium">Dalam semua materi</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shadow-inner">
                ✏️
            </div>
        </div>

        <!-- Soal Kuis -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Soal Kuis</p>
                <p class="text-3xl font-black text-slate-800 mt-2">{{ $totalSoalKuis }}</p>
                <p class="text-xs text-purple-600 mt-1 font-medium">Bank soal kuis global</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shadow-inner">
                📝
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pengguna</p>
                <p class="text-3xl font-black text-slate-800 mt-2">{{ $totalUsers }}</p>
                <p class="text-xs text-amber-600 mt-1 font-medium">{{ $totalVisitors }} Kunjungan Web</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shadow-inner">
                👥
            </div>
        </div>
    </div>

    <!-- Content Sections: Recent Materi & Users -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Materi -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span>📚</span> Materi Terbaru
                </h3>
                <a href="{{ route('admin.materi') }}" class="text-xs font-semibold text-green-600 hover:text-green-700">Lihat Semua →</a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentMateris as $materi)
                    <div class="py-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-lg">
                                {{ $materi->icon ? '🖼️' : '📖' }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $materi->title }}</p>
                                <p class="text-xs text-slate-400">{{ $materi->category }} • {{ $materi->language->name ?? 'Semua' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                {{ $materi->percakapan_count }} Dialog • {{ $materi->soal_latihan_count }} Soal
                            </span>
                            <div class="mt-1">
                                <a href="{{ route('admin.materi.detail', $materi->id) }}" class="text-xs text-green-600 hover:underline font-medium">Kelola Konten</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 py-4 text-center">Belum ada materi dibuat.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span>👥</span> Pengguna Terdaftar Terbaru
                </h3>
                <a href="{{ route('admin.users') }}" class="text-xs font-semibold text-green-600 hover:text-green-700">Lihat Semua →</a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentUsers as $user)
                    <div class="py-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=16a34a&background=dcfce7' }}" 
                                 class="w-10 h-10 rounded-full object-cover border border-slate-200">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $user->name }}</p>
                                <p class="text-xs text-slate-400">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                            <p class="text-xs text-slate-400 mt-1">{{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 py-4 text-center">Belum ada pengguna.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
