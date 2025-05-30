<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Absences;
use App\Models\Center;
use App\Models\Room;
use App\Models\Slot;
use App\Models\Student;
use App\Models\Formation;
use Illuminate\Http\Request;

use function Illuminate\Log\log;

class AbsencesController extends Controller
{
    public function index()
    {
        $centers = Center::all();
        $weekDays = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi',
            'sunday' => 'Dimanche'
        ];
        $timeSlots = [
            '08:00:00' => '08h00',
            '11:00:00' => '11h00',
            '14:00:00' => '14h00'
        ];
        $rooms = Room::all();

        return view('admin.absences.index', compact('centers', 'weekDays', 'timeSlots', 'rooms'));
    }

    public function getRooms(Request $request)
    {
        $centerId = $request->get('center_id');

        // Récupérer les salles via la relation center
        $rooms = Room::where('center_id', $centerId)->get();

        return response()->json($rooms);
    }

    public function getStudents(Request $request)
    {
        $request->validate([
            'center_id' => 'required|exists:centers,id',
            'week_day' => 'required|string',
            'start_time' => 'required',
            'room_id' => 'required|exists:rooms,id'
        ]);

        // Trouver le slot correspondant
        $slot = Slot::where('week_day', $request->week_day)
                   ->where('start_time', $request->start_time)
                   ->where('room_id', $request->room_id)
                   ->first();

        if (!$slot) {
            return response()->json(['students' => [], 'slot_id' => null]);
        }

        $students = $slot->formation->students();

        // Récupérer les absences existantes pour ce slot
        $existingAbsences = Absences::where('slot_id', $slot->id)
                                  ->pluck('student_id')
                                  ->toArray();

        $studentsData = $students->map(function($student) use ($existingAbsences) {
            return [
                'id' => $student->id,
                'user_id' => $student->user_id,
                'name' => $student->user->last_name . ' ' . $student->user->first_name,
                'email' => $student->user->email,
                'is_absent' => in_array($student->id, $existingAbsences)
            ];
        });

        return response()->json([
            'students' => $studentsData,
            'slot_id' => $slot->id,
            'formation_name' => $slot->formation->name ?? 'Formation non définie'
        ]);
    }

    public function store($locale, Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:slots,id',
            'absent_students' => 'array',
            'absent_students.*' => 'exists:students,id'
        ]);

        $slotId = $request->slot_id;
        $absentStudentIds = $request->absent_students ?? [];

        // Supprimer toutes les absences existantes pour ce slot
        Absences::where('slot_id', $slotId)->delete();

        // Créer les nouvelles absences
        foreach ($absentStudentIds as $studentId) {
            Absences::create([
                'student_id' => $studentId,
                'slot_id' => $slotId
            ]);
        }

        return redirect()->back()->with('success', 'Absences enregistrées avec succès !');
    }
}
