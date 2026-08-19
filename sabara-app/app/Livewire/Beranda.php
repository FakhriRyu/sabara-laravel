<?php

namespace App\Livewire;

use App\Models\Materi;
use App\Models\LatihanProgress;
use App\Models\QuizResult;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Beranda extends Component
{
    public $user;
    public $totalPoints;
    public $rank;
    public $categories;

    public function mount()
    {
        $this->user = auth()->user()->load('selectedLanguage');
        $this->calculateStats();
        $this->loadMateri();
    }

    public function calculateStats()
    {
        $userId = auth()->id();
        
        // Total poin = sum(latihan_progress.score * 10) + max(quiz_results.score)
        $latihanPoints = LatihanProgress::where('user_id', $userId)->sum('score') * 10;
        $quizPoints = QuizResult::where('user_id', $userId)->max('score') ?? 0;
        $this->totalPoints = $latihanPoints + $quizPoints;

        // Calculate rank
        $allUsers = User::select('users.id')
            ->selectRaw('(COALESCE((SELECT SUM(lp.score) * 10 FROM latihan_progress lp WHERE lp.user_id = users.id), 0) + COALESCE((SELECT MAX(qr.score) FROM quiz_results qr WHERE qr.user_id = users.id), 0)) as total_points')
            ->orderByDesc('total_points')
            ->get();
        
        $this->rank = $allUsers->search(function ($u) use ($userId) {
            return $u->id === $userId;
        }) + 1;
        
        if ($this->rank === 0) $this->rank = $allUsers->count() + 1;
    }

    public function loadMateri()
    {
        $languageId = auth()->user()->selected_language_id;
        $userId = auth()->id();
        
        $materis = Materi::where('language_id', $languageId)
            ->withCount(['soalLatihan'])
            ->with(['latihanProgress' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->get();

        $this->categories = $materis->groupBy('category')->map(function ($items, $category) {
            return [
                'name' => $category,
                'items' => $items->map(function ($materi) {
                    $totalLevels = $materi->soalLatihan->unique('level')->count();
                    if ($totalLevels === 0) $totalLevels = max(1, $materi->soal_latihan_count > 0 ? $materi->soalLatihan->max('level') : 1);
                    $completedLevels = $materi->latihanProgress->count();
                    return [
                        'id' => $materi->id,
                        'title' => $materi->title,
                        'description' => $materi->description,
                        'icon' => $materi->icon,
                        'totalLevels' => $totalLevels,
                        'completedLevels' => $completedLevels,
                        'progress' => $totalLevels > 0 ? round(($completedLevels / $totalLevels) * 100) : 0,
                    ];
                })->toArray(),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.beranda')
            ->layout('layouts.user');
    }
}
