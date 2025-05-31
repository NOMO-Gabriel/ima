<?php

namespace App\Http\Controllers;

use App\Models\Absences;
use App\Models\Center;
use App\Models\Slot;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsencesController extends Controller
{
    public function index(Request $request)
    {
        $centerId = $request->query('center_id');

        if (!$centerId) {
            $centers = Center::all();
            return view('admin.absences.select_center', compact('centers'));
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

        return view('admin.absences.index', [
            'timetable'     => $timetable,
            'center'        => $center,
            'weekStartDate' => $weekStart,
            'prevWeek'      => $prevWeek,
            'nextWeek'      => $nextWeek,
        ]);
    }

    public function list($locale, Slot $slot)
    {
        app()->setLocale($locale);

        $course = $slot->course;

        $students = $course
            ? $course->enrolledStudents
            : collect();

        $absentStudentIds = $slot->absences->pluck('student_id')->toArray();

        return view('admin.absences.list', compact('slot', 'students', 'absentStudentIds'));
    }

    public function toggle(Request $request, $locale)
    {
        $slotId = $request->input('slot_id');
        $studentId = $request->input('student_id');

        $absence = Absences::where('slot_id', $slotId)
            ->where('student_id', $studentId)
            ->first();

        if ($absence) {
            $absence->delete(); // mark present
        } else {
            Absences::create([
                'slot_id' => $slotId,
                'student_id' => $studentId,
            ]); // mark absent
        }

        return back();
    }

    public function show(Slot $slot)
    {
        // if (!$this->user || !$this->user->can('absences.view')) {
        //     abort(403, 'Non autorisé');
        // }

        $course = $slot->course;
        $students = $course->enrolledStudents;
        $absences = Absences::where('slot_id', $slot->id);

        $absentStudentIds = $absences->pluck('student_id')->toArray();

        $students = $course->enrolledStudents()->map(function ($student) use ($absentStudentIds) {
            $student->is_absent = in_array($student->id, $absentStudentIds);
            return $student;
        });

        return view('admin.absences.show', compact('students', 'slot'));
    }

    public function store(Request $request, Slot $slot)
    {
        // Vérification d'autorisation si nécessaire
        // if (!$this->user || !$this->user->can('absences.edit')) {
        //     abort(403, 'Non autorisé');
        // }

        $statuses = $request->input('statuses', []);

        foreach ($statuses as $studentId => $status) {
            if ($status === 'absent') {
                // Crée une absence si elle n’existe pas encore
                Absences::firstOrCreate([
                    'slot_id' => $slot->id,
                    'student_id' => $studentId,
                ]);
            } else {
                // Supprime l'absence si l'élève est finalement présent
                Absences::where('slot_id', $slot->id)
                       ->where('student_id', $studentId)
                       ->delete();
            }
        }

        log_history('updated', $slot, ['before' => $slot->toArray(), 'after' => $slot->toArray()]);

        return redirect()->route('admin.absences.show', $slot->id)
                         ->with('success', 'Présences enregistrées avec succès.');
    }

    public function edit(Absences $absence)
    {
        if (!$this->user || !$this->user->can('absences.edit')) {
            abort(403, 'Non autorisé');
        }

        return view('absences.edit', compact('absence'));
    }

    public function update(Request $request, Absences $absence)
    {
        if (!$this->user || !$this->user->can('absences.edit')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:users,id'],
            'slot_id' => ['required', 'integer', 'exists:slots,id'],
        ]);

        $absence->update($validated);

        log_history('updated', $absence, ['before' => $absence->toArray(), 'after' => $validated]);

        return redirect()->route('absences.index')
            ->with('success', 'Absences mise à jour avec succès.');
    }

    public function destroy(Absences $absence)
    {
        if (!$this->user || !$this->user->can('absences.delete')) {
            abort(403, 'Non autorisé');
        }

        $absence->delete();

        log_history('deleted', $absence, ['before' => $absence->toArray(), 'after' => []]);

        return redirect()->route('absences.index')
            ->with('success', 'Absences supprimée avec succès.');
    }
}
