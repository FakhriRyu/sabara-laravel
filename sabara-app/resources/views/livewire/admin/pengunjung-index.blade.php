<div>
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Analitik Pengunjung</h2>
            <p class="text-gray-600 mt-1">Pantau trafik dan aktivitas pengunjung platform.</p>
        </div>
        <button wire:click="refreshData" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg shadow-sm transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Refresh Data
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Page Views</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalPageViews) }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pengunjung Unik</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalUniqueVisitors) }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Kunjungan Hari Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($todayViews) }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="p-3 bg-orange-50 text-orange-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Kunjungan 7 Hari Terakhir</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($last7DaysViews) }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Trafik 14 Hari Terakhir</h3>
            <div class="relative h-72 w-full" wire:ignore>
                <canvas id="trafficChart"></canvas>
            </div>
        </div>

        <!-- Top Pages -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Halaman Paling Sering Dikunjungi</h3>
            </div>
            <div class="overflow-y-auto flex-grow max-h-72">
                <ul class="divide-y divide-gray-100">
                    @forelse($topPages as $page)
                        <li class="p-4 hover:bg-gray-50 flex justify-between items-center">
                            <span class="text-sm text-gray-700 font-medium truncate w-3/4" title="{{ $page->path }}">/{{ $page->path }}</span>
                            <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ number_format($page->views) }}</span>
                        </li>
                    @empty
                        <li class="p-4 text-center text-sm text-gray-500">Belum ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Logs Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Log Aktivitas Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="p-4 text-sm font-semibold text-gray-600">Waktu</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Path</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Session ID</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Perangkat / User Agent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentLogs as $log)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $log->created_at->diffForHumans() }}
                            </td>
                            <td class="p-4 text-sm font-medium text-gray-800">
                                /{{ $log->path }}
                            </td>
                            <td class="p-4 text-sm text-gray-500 font-mono text-xs">
                                {{ Str::limit($log->session_id, 8, '') }}...
                            </td>
                            <td class="p-4 text-xs text-gray-500 max-w-xs truncate" title="{{ $log->user_agent }}">
                                {{ $log->user_agent }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">Belum ada log aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endassets
    
    @script
    <script>
        const ctx = document.getElementById('trafficChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartDates),
                    datasets: [
                        {
                            label: 'Page Views',
                            data: @json($chartViews),
                            borderColor: 'rgb(79, 70, 229)', // Indigo-600
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Pengunjung Unik',
                            data: @json($chartUniques),
                            borderColor: 'rgb(16, 185, 129)', // Emerald-500
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
    </script>
    @endscript
</div>
