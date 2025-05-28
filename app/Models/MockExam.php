<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExam extends Model
{
    /** @use HasFactory<\Database\Factories\MockupEntranceExamFactory> */
    use HasFactory;

    protected $fillable = [
        'date',
        'type',
        'duration',
        'formation_id',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_exams')
                    ->withPivot('max_note')
                    ->withTimestamps();
    }
}
