<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    /** @use HasFactory<\Database\Factories\SlotFactory> */
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'week_day',
        'room',
        'timetable_id',
        'teacher_id',
        'course_id',
    ];

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
}
