<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    /** @use HasFactory<\Database\Factories\SlotFactory> */
    use HasFactory;

    protected $fillable = [
        'day',
        'start',
        'end',
        'formation_id',
        'teacher_id',
        'room_id',
        'timetable_id',
    ];

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }
}
