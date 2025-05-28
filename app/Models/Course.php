<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
    ];

    // Relations
    public function formations(): BelongsToMany
    {
        return $this->belongsToMany(Formation::class, 'course_formations');
    }

    public function mockExams(): BelongsToMany
    {
        return $this->belongsToMany(MockExam::class, 'course_mock_exams')
                    ->withPivot('max_note')
                    ->withTimestamps();
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
