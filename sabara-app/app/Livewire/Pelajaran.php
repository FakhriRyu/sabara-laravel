<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Materi;
use App\Models\SoalLatihan;
use App\Models\LatihanProgress;
use Illuminate\Support\Facades\Auth;

class Pelajaran extends Component
{
    public $materiId;
    public $materi;
    public $percakapan = [];
    public $levels = [];
    public $progress = [];

    public function mount($materiId)
    {
        $this->materiId = $materiId;
        $user = Auth::user();
        
        $this->materi = Materi::with(['percakapan' => function($query) {
            $query->orderBy('order_index');
        }])->findOrFail($materiId);
        
        // Ensure language matches if user selected language
        if ($user && $user->selected_language_id && $this->materi->language_id && $this->materi->language_id !== $user->selected_language_id) {
            return redirect()->route('beranda')->with('error', 'Materi tidak sesuai dengan bahasa yang dipilih.');
        }

        $this->percakapan = $this->materi->percakapan;

        // Get unique levels for this materi
        $this->levels = SoalLatihan::where('materi_id', $this->materiId)
            ->distinct()
            ->orderBy('level')
            ->pluck('level')
            ->toArray();

        // Get user progress
        $progressRecords = LatihanProgress::where('user_id', $user->id)
            ->where('materi_id', $this->materiId)
            ->get();
            
        foreach ($progressRecords as $record) {
            $this->progress[$record->level] = [
                'stars' => $record->stars,
                'score' => $record->score
            ];
        }
    }

    #[Layout('layouts.user')]
    public function render()
    {
        return view('livewire.pelajaran');
    }
}
