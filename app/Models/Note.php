<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'student_id',
        'course_id',
        'mock_exam_id',
    ];

    protected $casts = [
        'value' => 'float',
    ];

    // Relations
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function mockExam(): BelongsTo
    {
        return $this->belongsTo(MockExam::class);
    }
}
