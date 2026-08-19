<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoalLatihan extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'soal_latihan';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'materi_id',
        'question',
        'options',
        'answer',
        'type',
        'audio_url',
        'level',
        'star',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'options' => 'array',
            'level' => 'integer',
            'star' => 'integer',
        ];
    }

    /**
     * Get the materi that this question belongs to.
     */
    public function materi(): BelongsTo
    {
        return $this->belongsTo(Materi::class);
    }
}
