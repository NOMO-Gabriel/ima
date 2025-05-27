<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Formation;
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
            return view('admin.planning.select_center', compact('centers'));
        }

        $center = Center::findOrFail($centerId);

        // Formations avec leurs salles (rooms)
        $formations = Formation::with('rooms')->get();

        // Début de semaine (lundi)
        $weekStart = $request->filled('week_start_date')
            ? Carbon::parse($request->input('week_start_date'))->startOfWeek()
            : Carbon::now()->startOfWeek();

        // Jours de la semaine (lundi à vendredi)
        $days = collect();
        for ($i = 0; $i < 5; $i++) {
            $days->push($weekStart->copy()->addDays($i));
        }

        $dayNames = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

        // Périodes fixes
        $periods = [
            ['start' => '08:00:00', 'end' => '10:30:00'],
            ['start' => '11:00:00', 'end' => '13:30:00'],
            ['start' => '14:00:00', 'end' => '16:30:00'],
        ];

        // Emploi du temps de la semaine pour ce centre
        $timetable = $center->timetables()
            ->whereDate('week_start_date', $weekStart)
            ->with(['slots.room', 'slots.course', 'slots.formation', 'slots.teacher'])
            ->first();

        // Création si inexistant
        if (!$timetable) {
            $timetable = Timetable::createWithDefaultSlots($center, $weekStart);
            $timetable = $center->timetables()
                ->whereDate('week_start_date', $weekStart)
                ->with(['slots.room', 'slots.course', 'slots.formation', 'slots.teacher'])
                ->first();
        }

        // Générer les slots manquants pour toutes les salles listées dans les formations
        foreach ($formations as $formation) {
            foreach ($formation->rooms as $room) {
                $formationSlots = \App\Models\Slot::where('formation_id', $formation->id)->get();

                foreach ($formationSlots as $formationSlot) {
                    $exists = $timetable->slots->contains(function ($slot) use ($formationSlot, $room) {
                        return $slot->week_day === $formationSlot->week_day
                            && $slot->start_time === $formationSlot->start_time
                            && $slot->end_time === $formationSlot->end_time
                            && $slot->room_id === $room->id;
                    });

                    if (!$exists) {
                        \App\Models\Slot::create([
                            'timetable_id' => $timetable->id,
                            'week_day'     => $formationSlot->week_day,
                            'start_time'   => $formationSlot->start_time,
                            'end_time'     => $formationSlot->end_time,
                            'room_id'      => $room->id,
                            'formation_id' => $formation->id,
                            'course_id'    => $formationSlot->course_id,
                            'teacher_id'   => $formationSlot->teacher_id,
                        ]);
                    }
                }
            }
        }

        // Rechargement des relations
        $timetable->load(['slots.room', 'slots.course', 'slots.formation', 'slots.teacher']);

        // Navigation semaine précédente / suivante
        $prevWeek = $weekStart->copy()->subWeek()->toDateString();
        $nextWeek = $weekStart->copy()->addWeek()->toDateString();

        return view('admin.planning.index', [
            'timetable' => $timetable,
            'formations' => $formations,
            'days' => $days,
            'dayNames' => $dayNames,
            'periods' => $periods,
            'center' => $center,
            'weekStartDate' => $weekStart,
            'prevWeek' => $prevWeek,
            'nextWeek' => $nextWeek,
        ]);
    }
}