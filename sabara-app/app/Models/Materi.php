<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materi extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'materi';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'language_id',
        'title',
        'category',
        'description',
        'icon',
    ];

    /**
     * Get the language that this materi belongs to.
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the percakapan items for this materi.
     */
    public function percakapan(): HasMany
    {
        return $this->hasMany(Percakapan::class);
    }

    /**
     * Alias for percakapan.
     */
    public function percakapans(): HasMany
    {
        return $this->hasMany(Percakapan::class);
    }

    /**
     * Get the soal latihan questions for this materi.
     */
    public function soalLatihan(): HasMany
    {
        return $this->hasMany(SoalLatihan::class);
    }

    /**
     * Get the latihan progress records for this materi.
     */
    public function latihanProgress(): HasMany
    {
        return $this->hasMany(LatihanProgress::class);
    }

    /**
     * Alias for latihanProgress.
     */
    public function latihanProgresses(): HasMany
    {
        return $this->hasMany(LatihanProgress::class);
    }
}
