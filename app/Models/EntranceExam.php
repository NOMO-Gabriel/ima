<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EntranceExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    // Relations
    public function formations(): BelongsToMany
    {
        return $this->belongsToMany(Formation::class, 'entrance_exam_formations');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}
