<?php

namespace App\Services;

use App\Models\Timetable;
use App\Models\Slot;
use App\Models\ReferenceSlot;
use Carbon\Carbon;

class TimetableService
{
    public static function generateForWeek(Carbon $weekStartDate): Timetable
    {
        // Vérifie s'il existe déjà
        $existing = Timetable::where('week_start_date', $weekStartDate->toDateString())->first();
        if ($existing) return $existing;

        // Crée le nouveau timetable
        $timetable = Timetable::create([
            'week_start_date' => $weekStartDate->toDateString(),
        ]);

        // Récupère les slots de référence
        $referenceSlots = Slot::all();

        foreach ($referenceSlots as $refSlot) {
            Slot::create([
                'start_time' => $refSlot->start_time,
                'end_time' => $refSlot->end_time,
                'week_day' => $refSlot->week_day,
                'room' => $refSlot->room,
                'teacher_id' => $refSlot->teacher_id,
                'course_id' => $refSlot->course_id,
                'timetable_id' => $timetable->id,
            ]);
        }

        return $timetable;
    }
}
