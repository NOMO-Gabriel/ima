<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
    ];

    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'course_formations');
    }

    public function enrolledStudents()
    {
        return $this->formations
            ->flatMap(fn($formation) => $formation->entranceExams)
            ->flatMap(fn($exam) => $exam->students)
            ->unique('id')
            ->values();
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'course_exams')
                    ->withPivot('max_note')
                    ->withTimestamps();
    }
}
