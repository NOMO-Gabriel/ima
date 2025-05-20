<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Timetable;
use App\Models\Slot;

class TimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Week of Monday 19 May 2025
        $startDate = Carbon::createFromDate(2025, 5, 19);

        $timetable = Timetable::create([
            'week_start_date' => $startDate->toDateString(),
            'day_start_time' => '08:00:00',
            'day_end_time' => '16:30:00',
        ]);

        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $slots = [
            ['08:00:00', '10:30:00'],
            ['11:00:00', '13:30:00'],
            ['14:00:00', '16:30:00'],
        ];

        foreach ($weekDays as $day) {
            foreach ($slots as [$start, $end]) {
                Slot::create([
                    'start_time' => $start,
                    'end_time' => $end,
                    'week_day' => $day,
                    'room' => null,
                    'timetable_id' => $timetable->id,
                    'teacher_id' => null,
                    'course_id' => null,
                ]);
            }
        }
    }
}