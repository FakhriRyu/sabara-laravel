<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class PengunjungIndex extends Component
{
    public function render()
    {
        return view('livewire.admin.pengunjung-index')
            ->layout('layouts.app');
    }
}
