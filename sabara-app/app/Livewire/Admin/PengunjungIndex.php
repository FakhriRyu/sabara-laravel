<?php

namespace App\Livewire\Admin;

use App\Models\VisitorLog;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengunjungIndex extends Component
{
    public function render()
    {
        $totalPageViews = VisitorLog::count();
        $totalUniqueVisitors = VisitorLog::distinct('session_id')->count('session_id');
        
        $todayViews = VisitorLog::whereDate('created_at', Carbon::today())->count();
        $last7DaysViews = VisitorLog::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        // Chart data for last 14 days
        $chartData = VisitorLog::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'), DB::raw('count(distinct session_id) as unique_visitors'))
            ->where('created_at', '>=', Carbon::now()->subDays(14))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
            
        $dates = $chartData->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        })->toArray();
        $views = $chartData->pluck('views')->toArray();
        $uniques = $chartData->pluck('unique_visitors')->toArray();

        // Top pages
        $topPages = VisitorLog::select('path', DB::raw('count(*) as views'))
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        // Recent logs
        $recentLogs = VisitorLog::latest()->limit(20)->get();

        return view('livewire.admin.pengunjung-index', [
            'totalPageViews' => $totalPageViews,
            'totalUniqueVisitors' => $totalUniqueVisitors,
            'todayViews' => $todayViews,
            'last7DaysViews' => $last7DaysViews,
            'chartDates' => $dates,
            'chartViews' => $views,
            'chartUniques' => $uniques,
            'topPages' => $topPages,
            'recentLogs' => $recentLogs,
        ])->layout('layouts.admin');
    }
    
    public function refreshData()
    {
        // Just triggers re-render
    }
}
