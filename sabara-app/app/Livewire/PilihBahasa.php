<?php

namespace App\Livewire;

use App\Models\Language;
use Livewire\Component;

class PilihBahasa extends Component
{
    public $languages;
    public $selectedId;

    public function mount()
    {
        $this->languages = Language::where('is_active', true)->get();
        $this->selectedId = auth()->user()->selected_language_id;
    }

    public function selectLanguage($languageId)
    {
        auth()->user()->update(['selected_language_id' => $languageId]);
        return redirect()->route('beranda');
    }

    public function render()
    {
        return view('livewire.pilih-bahasa')
            ->layout('layouts.user');
    }
}
