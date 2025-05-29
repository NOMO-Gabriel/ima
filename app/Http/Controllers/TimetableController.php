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
        $formationId = $request->query('formation_id');

        // Étape 1 : Sélection du centre
        if (!$centerId) {
            $centers = Center::all();
            return view('admin.planning.select_center', compact('centers'));
        }

        $center = Center::findOrFail($centerId);

        // Étape 2 : Sélection de la formation
        if (!$formationId) {
            $formations = Formation::all();

            return view('admin.planning.select_formation', compact('center', 'formations'));
        }

        // Étape 3 : Affichage de l'emploi du temps pour la formation sélectionnée
        $formation = Formation::with('rooms')->findOrFail($formationId);

        // Vérifier que la formation a des salles dans ce centre
        $formationRooms = $formation->rooms->where('center_id', $centerId);
        if ($formationRooms->isEmpty()) {
            return redirect()->route('admin.planning.index', [
                'locale' => app()->getLocale(),
                'center_id' => $centerId
            ])->with('error', 'Cette formation n\'a pas de salles dans ce centre.');
        }

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
            ->with(['slots' => function($query) use ($formationId) {
                $query->where('formation_id', $formationId)
                      ->with(['room', 'course', 'formation', 'teacher']);
            }])
            ->first();

        // Création si inexistant
        if (!$timetable) {
            $timetable = Timetable::createWithDefaultSlots($center, $weekStart, $formationId);
            $timetable = $center->timetables()
                ->whereDate('week_start_date', $weekStart)
                ->with(['slots' => function($query) use ($formationId) {
                    $query->where('formation_id', $formationId)
                          ->with(['room', 'course', 'formation', 'teacher']);
                }])
                ->first();
        }

        // Créer les slots manquants pour cette formation uniquement
        $this->createMissingSlots($timetable, $formation, $formationRooms, $dayNames, $periods);

        // Rechargement des relations
        $timetable->load(['slots' => function($query) use ($formationId) {
            $query->where('formation_id', $formationId)
                  ->with(['room', 'course', 'formation', 'teacher']);
        }]);

        // Navigation semaine précédente / suivante
        $prevWeek = $weekStart->copy()->subWeek()->toDateString();
        $nextWeek = $weekStart->copy()->addWeek()->toDateString();

        return view('admin.planning.index', [
            'timetable' => $timetable,
            'formation' => $formation,
            'formationRooms' => $formationRooms,
            'days' => $days,
            'dayNames' => $dayNames,
            'periods' => $periods,
            'center' => $center,
            'weekStartDate' => $weekStart,
            'prevWeek' => $prevWeek,
            'nextWeek' => $nextWeek,
        ]);
    }

    /**
     * Créer les slots manquants pour une formation spécifique
     */
    private function createMissingSlots($timetable, $formation, $rooms, $dayNames, $periods)
    {
        $existingSlots = $timetable->slots->mapWithKeys(function ($slot) {
            return [$slot->week_day . $slot->start_time . $slot->end_time . $slot->room_id => true];
        })->toArray();

        // Récupérer les slots de formation (template)
        $formationSlots = $formation->slots;

        foreach ($rooms as $room) {
            foreach ($formationSlots as $formationSlot) {
                $key = $formationSlot->week_day . $formationSlot->start_time . $formationSlot->end_time . $room->id;

                if (!isset($existingSlots[$key])) {
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

                    $existingSlots[$key] = true;
                }
            }
        }
    }

    /**
     * Changer de formation sans perdre le centre et la semaine
     */
    public function changeFormation(Request $request)
    {
        $centerId = $request->input('center_id');
        $formationId = $request->input('formation_id');
        $weekStartDate = $request->input('week_start_date');

        return redirect()->route('admin.planning.index', [
            'locale' => app()->getLocale(),
            'center_id' => $centerId,
            'formation_id' => $formationId,
            'week_start_date' => $weekStartDate
        ]);
    }
}
