<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MockExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'type',
        'duration',
        'formation_id',
    ];

    protected $casts = [
        'date' => 'datetime',
        'duration' => 'integer',
    ];

    // Relations
    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_mock_exams')
                    ->withPivot('max_note')
                    ->withTimestamps();
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
