<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class MateriDetail extends Component
{
    public function render()
    {
        return view('livewire.admin.materi-detail')
            ->layout('layouts.app');
    }
}
