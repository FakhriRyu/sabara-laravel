<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the materi items for the language.
     */
    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class);
    }

    /**
     * Alias for materi.
     */
    public function materis(): HasMany
    {
        return $this->hasMany(Materi::class);
    }

    /**
     * Get the users who selected this language.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'selected_language_id');
    }

    /**
     * Get the quiz questions for this language.
     */
    public function soalKuis(): HasMany
    {
        return $this->hasMany(SoalKuis::class);
    }
}
