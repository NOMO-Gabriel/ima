<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function edit($locale, Slot $slot)
    {
        $courses  = Course::all();
        $teachers = User::whereHas('roles', function($query) {
            $query->where('name', 'enseignant');
        })->get();

        return view('admin.slots.edit', compact('slot', 'teachers', 'courses'));
    }

    public function update($locale, Request $request, Slot $slot)
    {
        $validated = $request->validate([
            'room'       => 'nullable|string|max:255',
            'teacher_id' => 'nullable|exists:users,id',
            'course_id'  => 'nullable|exists:courses,id',
        ]);

        $slot->update($validated);

        return redirect()
            ->route('admin.timetables.index', ['locale' => app()->getLocale(), 'week_start_date' => $slot->timetable->week_start_date])
            ->with('success', 'Créneau mis à jour avec succès.');
    }
}
