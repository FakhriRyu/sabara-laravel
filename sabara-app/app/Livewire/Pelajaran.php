<?php

namespace App\Livewire;

use Livewire\Component;

class Pelajaran extends Component
{
    public function render()
    {
        return view('livewire.pelajaran')
            ->layout('layouts.user');
    }
}
