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
            $formations = Formation::whereHas('rooms', function($query) use ($centerId) {
                $query->where('center_id', $centerId);
            })->get();

            return view('admin.planning.select_formation', compact('center', 'formations'));
        }

        // Étape 3 : Affichage de l'emploi du temps pour la formation sélectionnée
        $formation = Formation::with(['rooms' => function($query) use ($centerId) {
            $query->where('center_id', $centerId);
        }])->findOrFail($formationId);

        // Vérifier que la formation a des salles dans ce centre
        $formationRooms = $formation->rooms;
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

        // Trouver ou créer l'emploi du temps de la semaine
        $timetable = $center->timetables()
            ->whereDate('week_start_date', $weekStart)
            ->first();

        if (!$timetable) {
            $timetable = Timetable::create([
                'center_id' => $center->id,
                'week_start_date' => $weekStart->toDateString(),
                'day_start_time' => '08:00:00',
                'day_end_time' => '16:30:00',
            ]);
        }

        // Charger les slots existants pour cette formation uniquement
        $slots = $timetable->slots()
            ->where('formation_id', $formationId)
            ->with(['room', 'course', 'formation', 'teacher'])
            ->get();

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
            'slots' => $slots,
        ]);
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
