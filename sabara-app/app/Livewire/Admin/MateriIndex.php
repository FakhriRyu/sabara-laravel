<?php

namespace App\Livewire\Admin;

use App\Models\Materi;
use App\Models\Language;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class MateriIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $languageFilter = '';
    public $categoryFilter = '';

    public $showModal = false;
    public $materiId;
    public $language_id;
    public $title;
    public $category;
    public $description;
    public $icon;
    public $existingIcon;

    protected $queryString = [
        'search' => ['except' => ''],
        'languageFilter' => ['except' => ''],
    ];

    public function rules()
    {
        return [
            'language_id' => 'required|exists:languages,id',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|max:1024',
        ];
    }

    public function mount()
    {
        $defaultLang = Language::where('is_active', true)->first();
        $this->language_id = $defaultLang ? $defaultLang->id : (Language::first()?->id ?? null);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['materiId', 'title', 'category', 'description', 'icon', 'existingIcon']);
        $defaultLang = Language::where('is_active', true)->first();
        $this->language_id = $defaultLang ? $defaultLang->id : (Language::first()?->id ?? null);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $materi = Materi::findOrFail($id);
        $this->materiId = $materi->id;
        $this->language_id = $materi->language_id;
        $this->title = $materi->title;
        $this->category = $materi->category;
        $this->description = $materi->description;
        $this->existingIcon = $materi->icon;
        $this->icon = null;

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $iconPath = $this->existingIcon;
        if ($this->icon) {
            $path = $this->icon->store('icons', 'public');
            $iconPath = '/storage/' . $path;
        }

        Materi::updateOrCreate(
            ['id' => $this->materiId],
            [
                'language_id' => $this->language_id,
                'title' => $this->title,
                'category' => $this->category,
                'description' => $this->description,
                'icon' => $iconPath,
            ]
        );

        $this->showModal = false;
        session()->flash('message', $this->materiId ? 'Materi berhasil diperbarui.' : 'Materi berhasil ditambahkan.');
    }

    public function delete($id)
    {
        Materi::findOrFail($id)->delete();
        session()->flash('message', 'Materi berhasil dihapus.');
    }

    public function render()
    {
        $query = Materi::with('language')
            ->withCount(['percakapan', 'soalLatihan'])
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->when($this->languageFilter, function ($q) {
                $q->where('language_id', $this->languageFilter);
            })
            ->latest();

        return view('livewire.admin.materi-index', [
            'materis' => $query->paginate(10),
            'languages' => Language::all(),
        ])->layout('layouts.admin');
    }
}
