<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    /** @use HasFactory<\Database\Factories\TimetableFactory> */
    use HasFactory;

    protected $fillable = [
        'center_id',
        'week_start_date',
        'day_start_time',
        'day_end_time',
    ];

    public function slots()
    {
        return $this->hasMany(Slot::class)->orderBy('week_day')->orderBy('start_time');
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    // I don't want to use Services
    public static function createWithDefaultSlots(Center $center, Carbon $weekStart): self
    {
        $timetable = self::create([
            'center_id'       => $center->id,
            'week_start_date' => $weekStart->toDateString(),
            'day_start_time'  => '08:00:00',
            'day_end_time'    => '16:30:00',
        ]);

        $weekDays = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
        $slots    = [
            ['08:00:00','10:30:00'],
            ['11:00:00','13:30:00'],
            ['14:00:00','16:30:00'],
        ];

        $slotData = [];
        foreach ($weekDays as $day) {
            foreach ($slots as [$start, $end]) {
                $slotData[] = [
                    'start_time' => $start,
                    'end_time' => $end,
                    'week_day' => $day,
                    'room' => null,
                    'timetable_id' => $timetable->id,
                    'teacher_id' => null,
                    'course_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Slot::insert($slotData);

        return $timetable;
    }
}
