<?php

namespace App\Livewire\Admin;

use App\Models\SoalKuis;
use App\Models\Language;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class KuisIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $difficultyFilter = '';

    public $showModal = false;
    public $soalId;

    public $language_id;
    public $question;
    public $option_a;
    public $option_b;
    public $option_c;
    public $option_d;
    public $answer = 'a';
    public $difficulty = 'Mudah';
    public $type = 'multiple_choice';

    protected $queryString = [
        'search' => ['except' => ''],
        'difficultyFilter' => ['except' => ''],
    ];

    public function rules()
    {
        return [
            'language_id' => 'required|exists:languages,id',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'answer' => ['required', Rule::in(['a', 'b', 'c', 'd'])],
            'difficulty' => ['required', Rule::in(['Mudah', 'Sedang', 'Sulit'])],
        ];
    }

    public function mount()
    {
        $defaultLang = Language::where('is_active', true)->first();
        if ($defaultLang) {
            $this->language_id = $defaultLang->id;
        } else {
            $firstLang = Language::first();
            $this->language_id = $firstLang ? $firstLang->id : null;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDifficultyFilter()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['soalId', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'answer']);
        $this->difficulty = 'Mudah';
        $this->type = 'multiple_choice';
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $soal = SoalKuis::findOrFail($id);
        $this->soalId = $soal->id;
        $this->language_id = $soal->language_id;
        $this->question = $soal->question;
        $options = $soal->options ?? [];
        $this->option_a = $options['a'] ?? '';
        $this->option_b = $options['b'] ?? '';
        $this->option_c = $options['c'] ?? '';
        $this->option_d = $options['d'] ?? '';
        $this->answer = $soal->answer;
        $this->difficulty = $soal->difficulty;
        $this->type = $soal->type ?? 'multiple_choice';

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $options = [
            'a' => $this->option_a,
            'b' => $this->option_b,
            'c' => $this->option_c,
            'd' => $this->option_d,
        ];

        SoalKuis::updateOrCreate(
            ['id' => $this->soalId],
            [
                'language_id' => $this->language_id,
                'question' => $this->question,
                'options' => $options,
                'answer' => $this->answer,
                'difficulty' => $this->difficulty,
                'type' => $this->type,
            ]
        );

        $this->showModal = false;
        session()->flash('message', $this->soalId ? 'Soal berhasil diperbarui.' : 'Soal berhasil ditambahkan.');
    }

    public function delete($id)
    {
        SoalKuis::findOrFail($id)->delete();
        session()->flash('message', 'Soal berhasil dihapus.');
    }

    public function render()
    {
        $query = SoalKuis::with('language')
            ->when($this->search, function ($q) {
                $q->where('question', 'like', '%' . $this->search . '%');
            })
            ->when($this->difficultyFilter, function ($q) {
                $q->where('difficulty', $this->difficultyFilter);
            })
            ->latest();

        return view('livewire.admin.kuis-index', [
            'soalList' => $query->paginate(10),
            'languages' => Language::all(),
        ])->layout('layouts.admin');
    }
}
