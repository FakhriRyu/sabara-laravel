<?php

namespace App\Livewire\Admin;

use App\Models\SoundEffect;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SoundEffects extends Component
{
    use WithFileUploads;

    public $uploads = [];

    protected $rules = [
        'uploads.*' => 'nullable|mimes:mp3,wav,ogg,m4a|max:2048', // Max 2MB
    ];

    public function uploadSound($type)
    {
        $this->validateOnly("uploads.{$type}");

        $file = $this->uploads[$type] ?? null;

        if ($file) {
            $path = $file->storeAs('audio/sound_effects', $type . '_' . time() . '.' . $file->getClientOriginalExtension(), 'public');
            
            $soundEffect = SoundEffect::where('type', $type)->first();
            
            if ($soundEffect && $soundEffect->audio_url) {
                // Delete old file if it exists and is local storage
                if (Storage::disk('public')->exists(str_replace('/storage/', '', $soundEffect->audio_url))) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $soundEffect->audio_url));
                }
            }
            
            if (!$soundEffect) {
                $labels = [
                    'correct' => 'Jawaban Benar',
                    'wrong' => 'Jawaban Salah',
                    'complete' => 'Latihan Selesai',
                ];
                $soundEffect = new SoundEffect();
                $soundEffect->type = $type;
                $soundEffect->label = $labels[$type] ?? $type;
            }

            $soundEffect->audio_url = '/storage/' . $path;
            $soundEffect->save();

            $this->uploads[$type] = null;
            session()->flash("message_{$type}", 'Efek suara berhasil diperbarui.');
        }
    }

    public function render()
    {
        $effects = SoundEffect::whereIn('type', ['correct', 'wrong', 'complete'])->get()->keyBy('type');

        return view('livewire.admin.sound-effects', [
            'effects' => $effects,
        ])->layout('layouts.admin');
    }
}
