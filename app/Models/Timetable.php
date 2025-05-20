<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    /** @use HasFactory<\Database\Factories\TimetableFactory> */
    use HasFactory;

    protected $fillable = [
        'week_start_date',
        'day_start_time',
        'day_end_time',
    ];

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }
}
