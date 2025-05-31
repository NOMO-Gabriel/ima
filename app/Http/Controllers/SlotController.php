<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Formation;
use App\Models\Room;
use App\Models\Slot;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    /**
     * Afficher le formulaire de création d'un slot
     */
    public function create(Request $request)
    {
        $timetable = Timetable::findOrFail($request->timetable_id);
        $formation = Formation::findOrFail($request->formation_id);
        $room = Room::findOrFail($request->room_id);

        $center = $timetable->center;
        $courses = Course::all();
        $teachers = User::all();

        $slotData = [
            'timetable_id' => $request->timetable_id,
            'formation_id' => $request->formation_id,
            'room_id' => $request->room_id,
            'week_day' => $request->week_day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ];

        return view('admin.slots.create', compact(
            'slotData',
            'center',
            'formation',
            'room',
            'courses',
            'teachers',
            'timetable'
        ));
    }

    /**
     * Enregistrer un nouveau slot
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'timetable_id' => 'required|exists:timetables,id',
            'formation_id' => 'required|exists:formations,id',
            'room_id' => 'required|exists:rooms,id',
            'week_day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'teacher_id' => 'nullable|exists:users,id',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        // Vérifier qu'il n'y a pas déjà un slot à ce créneau
        $existingSlot = Slot::where([
            'timetable_id' => $validated['timetable_id'],
            'formation_id' => $validated['formation_id'],
            'room_id' => $validated['room_id'],
            'week_day' => $validated['week_day'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ])->first();

        if ($existingSlot) {
            return back()->with('error', 'Un créneau existe déjà pour cette période.');
        }

        $slot = Slot::create($validated);

        log_history('created', $slot, ['before' => [], 'after' => $validated]);

        $timetable = $slot->timetable;

        return redirect()->route('admin.planning.index', [
            'locale' => app()->getLocale(),
            'center_id' => $timetable->center_id,
            'formation_id' => $validated['formation_id'],
            'week_start_date' => $timetable->week_start_date->toDateString(),
        ])->with('success', 'Créneau créé avec succès.');
    }

    /**
     * Afficher le formulaire d'édition d'un slot
     */
    public function edit($locale, Slot $slot)
    {
        $center = $slot->timetable->center;
        $formation = $slot->formation;
        $room = $slot->room;
        $courses = Course::all();
        $teachers = User::whereHas('roles', function($query) {
            $query->where('name', 'enseignant');
        })->get();

        return view('admin.slots.edit', compact(
            'slot',
            'center',
            'formation',
            'room',
            'teachers',
            'courses'
        ));
    }

    /**
     * Mettre à jour un slot
     */
    public function update($locale, Request $request, Slot $slot)
    {
        $validated = $request->validate([
            'teacher_id' => 'nullable|exists:users,id',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $slot->update($validated);

        log_history('updated', $slot, ['before' => $slot->toArray(), 'after' => $validated]);

        return redirect()->route('admin.planning.index', [
            'locale' => app()->getLocale(),
            'center_id' => $slot->timetable->center_id,
            'formation_id' => $slot->formation_id,
            'week_start_date' => $slot->timetable->week_start_date->toDateString(),
        ])->with('success', 'Créneau mis à jour avec succès.');
    }

    /**
     * Supprimer un slot
     */
    public function destroy($locale, Slot $slot)
    {
        $timetableId = $slot->timetable_id;
        $centerId = $slot->timetable->center_id;
        $formationId = $slot->formation_id;
        $weekStartDate = $slot->timetable->week_start_date->toDateString();

        $slot->delete();

        log_history('deleted', $slot, ['before' => $slot->toArray(), 'after' => []]);

        return redirect()->route('admin.planning.index', [
            'locale' => app()->getLocale(),
            'center_id' => $centerId,
            'formation_id' => $formationId,
            'week_start_date' => $weekStartDate,
        ])->with('success', 'Créneau supprimé avec succès.');
    }
}
