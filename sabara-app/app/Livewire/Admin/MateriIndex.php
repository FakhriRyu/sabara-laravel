<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class MateriIndex extends Component
{
    public function render()
    {
        return view('livewire.admin.materi-index')
            ->layout('layouts.app');
    }
}
