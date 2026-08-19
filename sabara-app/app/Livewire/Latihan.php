<?php

namespace App\Livewire;

use App\Models\LatihanProgress;
use App\Models\Materi;
use App\Models\SoalLatihan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Latihan extends Component
{
    public $categoryId;
    public $level = 1;
    public $soalList = [];
    public $currentIndex = 0;
    public $score = 0;
    public $stars = 0;
    public $selectedAnswer = null;
    public $isAnswered = false;
    public $isCorrect = false;
    public $isComplete = false;

    protected $queryString = ['categoryId', 'level'];

    public function mount()
    {
        $this->categoryId = request()->query('categoryId', $this->categoryId);
        $this->level = (int) request()->query('level', 1);

        $soalRecords = SoalLatihan::where('materi_id', $this->categoryId)
            ->where('level', $this->level)
            ->inRandomOrder()
            ->get();

        $this->soalList = $soalRecords->map(function ($soal) {
            $options = is_string($soal->options) ? json_decode($soal->options, true) : $soal->options;
            return [
                'id' => $soal->id,
                'type' => $soal->type ?? 'multiple_choice',
                'question_text' => $soal->question,
                'options' => $options ?? [],
                'correct_answer' => $soal->answer,
                'audio_url' => $soal->audio_url,
                'level' => $soal->level,
                'star' => $soal->star,
            ];
        })->toArray();
    }

    public function checkAnswer($answer)
    {
        if ($this->isAnswered || empty($this->soalList)) {
            return;
        }

        $this->selectedAnswer = $answer;
        $this->isAnswered = true;

        $currentSoal = $this->soalList[$this->currentIndex];
        $correctAnswer = $currentSoal['correct_answer'];

        if (trim((string)$answer) === trim((string)$correctAnswer)) {
            $this->isCorrect = true;
            $this->score++;
            $this->dispatch('play-sound', type: 'correct');
        } else {
            $this->isCorrect = false;
            $this->dispatch('play-sound', type: 'wrong');
        }
    }

    public function nextQuestion()
    {
        $this->currentIndex++;

        if ($this->currentIndex >= count($this->soalList)) {
            $this->finishLatihan();
        } else {
            $this->resetQuestionState();
        }
    }

    public function resetQuestionState()
    {
        $this->selectedAnswer = null;
        $this->isAnswered = false;
        $this->isCorrect = false;
    }

    public function finishLatihan()
    {
        $this->isComplete = true;
        $total = count($this->soalList);

        if ($total > 0) {
            $percentage = ($this->score / $total) * 100;
            if ($percentage >= 80) {
                $this->stars = 3;
            } elseif ($percentage >= 50) {
                $this->stars = 2;
            } elseif ($this->score > 0) {
                $this->stars = 1;
            } else {
                $this->stars = 0;
            }
        }

        $this->saveProgress();
        $this->dispatch('play-sound', type: 'complete');
    }

    public function saveProgress()
    {
        if (Auth::check() && $this->categoryId) {
            $existing = LatihanProgress::where('user_id', Auth::id())
                ->where('materi_id', $this->categoryId)
                ->where('level', $this->level)
                ->first();

            $bestScore = $existing ? max($existing->score, $this->score) : $this->score;
            $bestStars = $existing ? max($existing->stars, $this->stars) : $this->stars;

            LatihanProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'materi_id' => $this->categoryId,
                    'level' => $this->level,
                ],
                [
                    'score' => $bestScore,
                    'stars' => $bestStars,
                ]
            );
        }
    }

    public function render()
    {
        return view('livewire.latihan')
            ->layout('layouts.user');
    }
}
