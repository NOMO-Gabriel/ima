<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Find the start of week to display
        if ($request->filled('week_start_date')) {
            $weekStart = Carbon::parse($request->input('week_start_date'))->startOfWeek();
        } else {
            $weekStart = Carbon::now()->startOfWeek();
        }

        // Find existant timetable
        $timetable = Timetable::where('week_start_date', $weekStart->toDateString())->first();

        // If not found, create
        if (!$timetable) {
            $timetable = Timetable::create([
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

            foreach ($weekDays as $day) {
                foreach ($slots as [$start, $end]) {
                    Slot::create([
                        'start_time'   => $start,
                        'end_time'     => $end,
                        'week_day'     => $day,
                        'room'         => null,
                        'timetable_id' => $timetable->id,
                        'teacher_id'   => null,
                        'course_id'    => null,
                    ]);
                }
            }
        }

        // Navigation dates
        $prevWeek = $weekStart->copy()->subWeek()->toDateString();
        $nextWeek = $weekStart->copy()->addWeek()->toDateString();

        return view('admin.timetables.index', [
            'timetable'     => $timetable,
            'weekStartDate' => $weekStart,
            'prevWeek'      => $prevWeek,
            'nextWeek'      => $nextWeek,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Timetable $timetable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timetable $timetable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timetable $timetable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timetable $timetable)
    {
        //
    }
}
