<?php

namespace App\Livewire\Admin;

use App\Models\Materi;
use App\Models\Percakapan;
use App\Models\SoalLatihan;
use Livewire\Component;
use Livewire\WithFileUploads;

class MateriDetail extends Component
{
    use WithFileUploads;

    public $materiId;
    public $activeTab = 'percakapan'; // 'percakapan' or 'soal'

    // Percakapan Form
    public $showPercakapanModal = false;
    public $percakapanId;
    public $indonesia = '';
    public $bengkulu = '';
    public $speaker = '1';
    public $audio;
    public $existingAudio;

    // Soal Latihan Form
    public $showSoalModal = false;
    public $soalId;
    public $questionType = 'multiple_choice'; // multiple_choice, matching, audio, reading
    public $question = '';
    public $level = 1;
    public $star = 1;
    public $options = [];
    public $answer = '';
    public $soalAudio;
    public $existingSoalAudio;

    // Multiple Choice helper fields
    public $mc_opt_a = '';
    public $mc_opt_b = '';
    public $mc_opt_c = '';
    public $mc_opt_d = '';

    // Matching helper fields
    public $matchingPairs = [
        ['indonesia' => '', 'bengkulu' => ''],
        ['indonesia' => '', 'bengkulu' => ''],
    ];

    // Bulk Import
    public $showBulkModal = false;
    public $bulkJson = '';

    public function mount($id)
    {
        $this->materiId = $id;
    }

    // --- Percakapan Methods ---
    public function createPercakapan()
    {
        $this->resetValidation();
        $this->reset(['percakapanId', 'indonesia', 'bengkulu', 'speaker', 'audio', 'existingAudio']);
        $this->speaker = '1';
        $this->showPercakapanModal = true;
    }

    public function editPercakapan($id)
    {
        $this->resetValidation();
        $p = Percakapan::findOrFail($id);
        $this->percakapanId = $p->id;
        $this->indonesia = $p->indonesia;
        $this->bengkulu = $p->bengkulu;
        $this->speaker = (string)$p->speaker;
        $this->existingAudio = $p->audio_url;
        $this->audio = null;
        $this->showPercakapanModal = true;
    }

    public function savePercakapan()
    {
        $this->validate([
            'indonesia' => 'required|string',
            'bengkulu' => 'required|string',
            'speaker' => 'required|in:1,2',
            'audio' => 'nullable|mimes:mp3,wav,ogg,m4a|max:3072',
        ]);

        $audioPath = $this->existingAudio;
        if ($this->audio) {
            $path = $this->audio->store('audio/percakapan', 'public');
            $audioPath = '/storage/' . $path;
        }

        $nextIndex = Percakapan::where('materi_id', $this->materiId)->max('order_index') + 1;

        Percakapan::updateOrCreate(
            ['id' => $this->percakapanId],
            [
                'materi_id' => $this->materiId,
                'indonesia' => $this->indonesia,
                'bengkulu' => $this->bengkulu,
                'speaker' => $this->speaker,
                'audio_url' => $audioPath,
                'order_index' => $this->percakapanId ? Percakapan::find($this->percakapanId)->order_index : $nextIndex,
            ]
        );

        $this->showPercakapanModal = false;
        session()->flash('message', $this->percakapanId ? 'Dialog diperbarui.' : 'Dialog ditambahkan.');
    }

    public function deletePercakapan($id)
    {
        Percakapan::findOrFail($id)->delete();
        session()->flash('message', 'Dialog dihapus.');
    }

    public function movePercakapan($id, $direction)
    {
        $current = Percakapan::findOrFail($id);
        $swapWith = $direction === 'up'
            ? Percakapan::where('materi_id', $this->materiId)->where('order_index', '<', $current->order_index)->orderByDesc('order_index')->first()
            : Percakapan::where('materi_id', $this->materiId)->where('order_index', '>', $current->order_index)->orderBy('order_index')->first();

        if ($swapWith) {
            $tempIndex = $current->order_index;
            $current->update(['order_index' => $swapWith->order_index]);
            $swapWith->update(['order_index' => $tempIndex]);
        }
    }

    // --- Soal Latihan Methods ---
    public function createSoal()
    {
        $this->resetValidation();
        $this->reset(['soalId', 'question', 'answer', 'soalAudio', 'existingSoalAudio', 'mc_opt_a', 'mc_opt_b', 'mc_opt_c', 'mc_opt_d']);
        $this->questionType = 'multiple_choice';
        $this->level = 1;
        $this->star = 1;
        $this->matchingPairs = [
            ['indonesia' => '', 'bengkulu' => ''],
            ['indonesia' => '', 'bengkulu' => ''],
        ];
        $this->showSoalModal = true;
    }

    public function editSoal($id)
    {
        $this->resetValidation();
        $soal = SoalLatihan::findOrFail($id);
        $this->soalId = $soal->id;
        $this->questionType = $soal->type ?? 'multiple_choice';
        $this->question = $soal->question;
        $this->answer = $soal->answer;
        $this->level = $soal->level;
        $this->star = $soal->star;
        $this->existingSoalAudio = $soal->audio_url;
        $this->soalAudio = null;

        $opts = is_string($soal->options) ? json_decode($soal->options, true) : $soal->options;
        
        if ($this->questionType === 'matching') {
            $this->matchingPairs = is_array($opts) && count($opts) > 0 ? $opts : [
                ['indonesia' => '', 'bengkulu' => ''],
                ['indonesia' => '', 'bengkulu' => ''],
            ];
        } else {
            $this->mc_opt_a = is_array($opts) ? ($opts[0] ?? ($opts['a'] ?? '')) : '';
            $this->mc_opt_b = is_array($opts) ? ($opts[1] ?? ($opts['b'] ?? '')) : '';
            $this->mc_opt_c = is_array($opts) ? ($opts[2] ?? ($opts['c'] ?? '')) : '';
            $this->mc_opt_d = is_array($opts) ? ($opts[3] ?? ($opts['d'] ?? '')) : '';
        }

        $this->showSoalModal = true;
    }

    public function addMatchingPair()
    {
        $this->matchingPairs[] = ['indonesia' => '', 'bengkulu' => ''];
    }

    public function removeMatchingPair($index)
    {
        unset($this->matchingPairs[$index]);
        $this->matchingPairs = array_values($this->matchingPairs);
    }

    public function saveSoal()
    {
        $this->validate([
            'question' => 'required|string',
            'level' => 'required|integer|min:1',
            'star' => 'required|integer|min:1|max:3',
        ]);

        $audioPath = $this->existingSoalAudio;
        if ($this->soalAudio) {
            $path = $this->soalAudio->store('audio/soal', 'public');
            $audioPath = '/storage/' . $path;
        }

        if ($this->questionType === 'matching') {
            $finalOptions = $this->matchingPairs;
            $finalAnswer = 'correct_order';
        } else {
            $finalOptions = array_values(array_filter([
                $this->mc_opt_a,
                $this->mc_opt_b,
                $this->mc_opt_c,
                $this->mc_opt_d,
            ]));
            $finalAnswer = $this->answer ?: ($finalOptions[0] ?? '');
        }

        SoalLatihan::updateOrCreate(
            ['id' => $this->soalId],
            [
                'materi_id' => $this->materiId,
                'question' => $this->question,
                'options' => $finalOptions,
                'answer' => $finalAnswer,
                'type' => $this->questionType,
                'audio_url' => $audioPath,
                'level' => $this->level,
                'star' => $this->star,
            ]
        );

        $this->showSoalModal = false;
        session()->flash('message', $this->soalId ? 'Soal diperbarui.' : 'Soal ditambahkan.');
    }

    public function deleteSoal($id)
    {
        SoalLatihan::findOrFail($id)->delete();
        session()->flash('message', 'Soal dihapus.');
    }

    public function duplicateSoal($id)
    {
        $orig = SoalLatihan::findOrFail($id);
        $clone = $orig->replicate();
        $clone->question = $orig->question . ' (Copy)';
        $clone->save();
        session()->flash('message', 'Soal berhasil diduplikasi.');
    }

    public function importBulk()
    {
        $this->validate([
            'bulkJson' => 'required|string',
        ]);

        $data = json_decode($this->bulkJson, true);
        if (!is_array($data)) {
            $this->addError('bulkJson', 'Format JSON tidak valid.');
            return;
        }

        $count = 0;
        foreach ($data as $item) {
            if (isset($item['question'])) {
                SoalLatihan::create([
                    'materi_id' => $this->materiId,
                    'question' => $item['question'],
                    'options' => $item['options'] ?? [],
                    'answer' => $item['answer'] ?? '',
                    'type' => $item['type'] ?? 'multiple_choice',
                    'audio_url' => $item['audio_url'] ?? null,
                    'level' => $item['level'] ?? 1,
                    'star' => $item['star'] ?? 1,
                ]);
                $count++;
            }
        }

        $this->showBulkModal = false;
        $this->bulkJson = '';
        session()->flash('message', "{$count} soal berhasil diimpor.");
    }

    public function render()
    {
        $materi = Materi::with(['language', 'percakapan' => fn($q) => $q->orderBy('order_index'), 'soalLatihan' => fn($q) => $q->orderBy('level')->orderBy('star')])->findOrFail($this->materiId);

        $groupedSoal = $materi->soalLatihan->groupBy('level');

        return view('livewire.admin.materi-detail', [
            'materi' => $materi,
            'groupedSoal' => $groupedSoal,
        ])->layout('layouts.admin');
    }
}
