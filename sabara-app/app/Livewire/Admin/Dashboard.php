<?php

namespace App\Livewire\Admin;

use App\Models\Materi;
use App\Models\SoalLatihan;
use App\Models\SoalKuis;
use App\Models\User;
use App\Models\VisitorLog;
use App\Models\Language;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalMateri = Materi::count();
        $totalSoalLatihan = SoalLatihan::count();
        $totalSoalKuis = SoalKuis::count();
        $totalUsers = User::count();
        $totalVisitors = VisitorLog::count();
        $totalLanguages = Language::where('is_active', true)->count();

        $recentMateris = Materi::with(['language'])->withCount(['percakapan', 'soalLatihan'])->latest()->take(5)->get();
        $recentUsers = User::with('selectedLanguage')->latest()->take(5)->get();

        return view('livewire.admin.dashboard', [
            'totalMateri' => $totalMateri,
            'totalSoalLatihan' => $totalSoalLatihan,
            'totalSoalKuis' => $totalSoalKuis,
            'totalUsers' => $totalUsers,
            'totalVisitors' => $totalVisitors,
            'totalLanguages' => $totalLanguages,
            'recentMateris' => $recentMateris,
            'recentUsers' => $recentUsers,
        ])->layout('layouts.admin');
    }
}
