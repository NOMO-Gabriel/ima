<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Slot;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $centerId = $request->query('center_id');

        if (!$centerId) {
            $centers = Center::all();
            return view('admin.timetables.select_center', compact('centers'));
        }

        $center = Center::findOrFail($centerId);

        // Find the start of week to display
        if ($request->filled('week_start_date')) {
            $weekStart = Carbon::parse($request->input('week_start_date'))->startOfWeek();
        } else {
            $weekStart = Carbon::now()->startOfWeek();
        }

        $timetable = $center->timetables()
            ->whereDate('week_start_date', $weekStart)
            ->with('slots')
            ->first();

        if (!$timetable) {
            $timetable = Timetable::createWithDefaultSlots($center, $weekStart);
        }

        // Navigation dates
        $prevWeek = $weekStart->copy()->subWeek()->toDateString();
        $nextWeek = $weekStart->copy()->addWeek()->toDateString();

        return view('admin.timetables.index', [
            'timetable'     => $timetable,
            'center'        => $center,
            'weekStartDate' => $weekStart,
            'prevWeek'      => $prevWeek,
            'nextWeek'      => $nextWeek,
        ]);
    }
}
