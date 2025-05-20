<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Course;
use App\Models\Room;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function edit($locale, Slot $slot)
    {
        $center = $slot->timetable->center;
        $courses  = Course::all();
        $teachers = User::whereHas('roles', function($query) {
            $query->where('name', 'enseignant');
        })->get();

        $rooms = Room::all();

        return view('admin.slots.edit', compact('slot', 'rooms', 'teachers', 'courses', 'center'));
    }

    public function update($locale, Request $request, Slot $slot)
    {
        $center = $slot->timetable->center;
        $validated = $request->validate([
            'room_id' => 'nullable|exists:rooms,id',
            'teacher_id' => 'nullable|exists:users,id',
            'course_id'  => 'nullable|exists:courses,id',
        ]);

        $slot->update($validated);

        return redirect()
            ->route('admin.timetables.index',
                [
                    'locale' => app()->getLocale(),
                    'week_start_date' => $slot->timetable->week_start_date,
                    'center_id' => $center->id,
                ])
            ->with('success', 'Créneau mis à jour avec succès.');
    }
}
