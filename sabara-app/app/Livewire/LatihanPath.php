<?php

namespace App\Livewire;

use App\Models\LatihanProgress;
use App\Models\Materi;
use App\Models\SoalLatihan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LatihanPath extends Component
{
    public $materiId;
    public $materi;
    public $progress = [];
    public $nodes = [];

    public function mount($materiId)
    {
        $this->materiId = $materiId;
        $this->materi = Materi::findOrFail($materiId);
        $userId = Auth::id();

        // Get user progress
        $progressRecords = LatihanProgress::where('user_id', $userId)
            ->where('materi_id', $this->materiId)
            ->get()
            ->keyBy('level');

        // 5 standard levels
        $this->nodes = [
            [
                'level' => 5,
                'name' => 'Latihan Akhir',
                'icon' => 'star',
                'type' => 'final',
                'position' => 'center',
                'is_completed' => isset($progressRecords[5]),
                'stars' => $progressRecords[5]->stars ?? 0,
            ],
            [
                'level' => 4,
                'name' => 'Membaca',
                'icon' => 'book',
                'type' => 'reading',
                'position' => 'left',
                'is_completed' => isset($progressRecords[4]),
                'stars' => $progressRecords[4]->stars ?? 0,
            ],
            [
                'level' => 3,
                'name' => 'Percakapan',
                'icon' => 'people',
                'type' => 'dialog',
                'position' => 'right',
                'is_completed' => isset($progressRecords[3]),
                'stars' => $progressRecords[3]->stars ?? 0,
            ],
            [
                'level' => 2,
                'name' => 'Terjemahan',
                'icon' => 'translate',
                'type' => 'matching',
                'position' => 'left',
                'is_completed' => isset($progressRecords[2]),
                'stars' => $progressRecords[2]->stars ?? 0,
            ],
            [
                'level' => 1,
                'name' => 'Mendengarkan',
                'icon' => 'headphones',
                'type' => 'audio',
                'position' => 'right',
                'is_completed' => isset($progressRecords[1]),
                'stars' => $progressRecords[1]->stars ?? 0,
            ],
        ];
    }

    public function startLevel($level)
    {
        return redirect()->route('latihan', [
            'categoryId' => $this->materiId,
            'level' => $level,
        ]);
    }

    public function render()
    {
        return view('livewire.latihan-path')
            ->layout('layouts.user');
    }
}
