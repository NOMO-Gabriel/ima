<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_start_date',
        'day_start_time',
        'day_end_time',
        'center_id',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'day_start_time' => 'datetime:H:i:s',
        'day_end_time' => 'datetime:H:i:s',
    ];

    // Relations
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }

    public static function createWithDefaultSlots(Center $center, Carbon $weekStart): self
    {
        $timetable = self::create([
            'center_id' => $center->id,
            'week_start_date' => $weekStart->toDateString(),
            'day_start_time' => '08:00:00',
            'day_end_time' => '16:30:00',
        ]);

        $weekDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $slots = [
            ['08:00:00','10:30:00'],
            ['11:00:00','13:30:00'],
            ['14:00:00','16:30:00'],
        ];

        $formations = Formation::with('rooms')->get();

        $slotData = [];
        foreach ($weekDays as $day) {
            foreach ($slots as [$start, $end]) {
                foreach ($formations as $formation) {
                    foreach ($formation->rooms as $room) {
                        $slotData[] = [
                            'start_time'   => $start,
                            'end_time'     => $end,
                            'week_day'     => $day,
                            'room_id'      => $room->id,
                            'formation_id' => $formation->id,
                            'timetable_id' => $timetable->id,
                            'teacher_id'   => null,
                            'course_id'    => null,
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ];
                    }
                }
            }
        }

        Slot::insert($slotData);

        return $timetable;
    }
}
