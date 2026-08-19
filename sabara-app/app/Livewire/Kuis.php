<?php

namespace App\Livewire;

use Livewire\Component;

class Kuis extends Component
{
    public function render()
    {
        return view('livewire.kuis')
            ->layout('layouts.user');
    }
}
