<?php

namespace App\Livewire;

use App\Models\LatihanProgress;
use App\Models\QuizResult;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profil extends Component
{
    use WithFileUploads;

    public $user;
    public $name;
    public $avatar;
    public $stats;

    public $showEditModal = false;
    public $showAboutModal = false;

    public function mount()
    {
        $this->user = auth()->user()->load('selectedLanguage');
        $this->name = $this->user->name;
        $this->calculateStats();
    }

    public function calculateStats()
    {
        $userId = auth()->id();
        
        $latihanPoints = LatihanProgress::where('user_id', $userId)->sum('score') * 10;
        $quizMax = QuizResult::where('user_id', $userId)->max('score') ?? 0;
        $totalPoints = $latihanPoints + $quizMax;
        
        $totalLatihan = LatihanProgress::where('user_id', $userId)->count();
        
        $allUsers = User::select('users.id')
            ->selectRaw('(COALESCE((SELECT SUM(lp.score) * 10 FROM latihan_progress lp WHERE lp.user_id = users.id), 0) + COALESCE((SELECT MAX(qr.score) FROM quiz_results qr WHERE qr.user_id = users.id), 0)) as total_points')
            ->orderByDesc('total_points')
            ->get();
        $rank = $allUsers->search(fn ($u) => $u->id === $userId) + 1;
        if ($rank === 0) $rank = $allUsers->count() + 1;

        $this->stats = [
            'totalPoints' => $totalPoints,
            'rank' => $rank,
            'totalLatihan' => $totalLatihan,
            'latihanPoints' => $latihanPoints,
            'quizMax' => $quizMax,
        ];
    }

    public function openEditModal()
    {
        $this->name = $this->user->name;
        $this->showEditModal = true;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|min:2|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $this->name;

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar_url = '/storage/' . $path;
        }

        $user->save();
        $this->user = $user->fresh()->load('selectedLanguage');
        $this->showEditModal = false;
        session()->flash('message', 'Profil berhasil diperbarui!');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.profil')
            ->layout('layouts.user');
    }
}
