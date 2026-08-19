<?php

namespace App\Livewire;

use Livewire\Component;

class PilihBahasa extends Component
{
    public function render()
    {
        return view('livewire.pilih-bahasa')
            ->layout('layouts.app');
    }
}
