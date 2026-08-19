<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SoundEffects extends Component
{
    public function render()
    {
        return view('livewire.admin.sound-effects')
            ->layout('layouts.app');
    }
}
