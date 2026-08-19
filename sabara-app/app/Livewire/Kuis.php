<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SoalKuis;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class Kuis extends Component
{
    public $isQuizActive = false;
    public $isComplete = false;
    public $questions = [];
    public $currentIndex = 0;
    public $score = 0;
    
    public $selectedAnswer = null;
    public $isAnswered = false;
    public $isCorrect = false;
    
    public $totalQuestions = 10;
    
    public $leaderboard = [];
    
    public function mount()
    {
        $this->loadLeaderboard();
    }
    
    public function loadLeaderboard()
    {
        if (Schema::hasTable('quiz_results')) {
            $this->leaderboard = User::withMax('quizResults as max_score', 'score')
                ->having('max_score', '>', 0)
                ->orderByDesc('max_score')
                ->take(20)
                ->get();
        }
    }
    
    public function startQuiz()
    {
        $user = Auth::user();
        
        // Ensure table exists before querying
        if (!Schema::hasTable('soal_kuis')) {
            $this->js("alert('Belum ada soal kuis tersedia')");
            return;
        }

        $query = SoalKuis::query();
        if ($user && Schema::hasColumn('users', 'selected_language_id') && $user->selected_language_id) {
            $query->where('language_id', $user->selected_language_id);
        }
        
        $this->questions = $query->inRandomOrder()->limit($this->totalQuestions)->get();
        
        if ($this->questions->isEmpty()) {
            $this->js("alert('Belum ada soal kuis tersedia')");
            return;
        }
        
        $this->totalQuestions = $this->questions->count();
        $this->isQuizActive = true;
        $this->isComplete = false;
        $this->currentIndex = 0;
        $this->score = 0;
        $this->resetQuestionState();
    }
    
    public function submitAnswer($answerKey)
    {
        if ($this->isAnswered) return;
        
        $this->selectedAnswer = $answerKey;
        $this->isAnswered = true;
        
        $currentQuestion = $this->questions[$this->currentIndex];
        
        if ((string)$answerKey === (string)$currentQuestion->correct_answer) {
            $this->isCorrect = true;
            $this->score += 10; // 10 points per question
        } else {
            $this->isCorrect = false;
        }
    }
    
    public function nextQuestion()
    {
        $this->currentIndex++;
        
        if ($this->currentIndex >= $this->totalQuestions) {
            $this->finishQuiz();
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
    
    public function finishQuiz()
    {
        $this->isQuizActive = false;
        $this->isComplete = true;
        
        if (Auth::check() && Schema::hasTable('quiz_results')) {
            QuizResult::create([
                'user_id' => Auth::id(),
                'score' => $this->score,
                'total_questions' => $this->totalQuestions,
            ]);
        }
    }
    
    public function backToLeaderboard()
    {
        $this->isComplete = false;
        $this->loadLeaderboard();
    }

    public function render()
    {
        return view('livewire.kuis')->layout('layouts.user');
    }
}
