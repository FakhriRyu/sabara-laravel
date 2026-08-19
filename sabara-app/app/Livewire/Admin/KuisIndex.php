<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class KuisIndex extends Component
{
    public function render()
    {
        return view('livewire.admin.kuis-index')
            ->layout('layouts.app');
    }
}
