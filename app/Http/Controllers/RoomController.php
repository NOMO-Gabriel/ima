<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        // if ($this->user && !$this->user->can('course.view')) {
        //     abort(403, 'Non autorisé');
        // }

        $query = Room::with('formation');

        // Filtre formation
        if ($request->filled('formation_id')) {
            $query->where('formation_id', $request->formation_id);
        }

        // Filtre recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filtre capacité
        if ($request->filled('capacity')) {
            $capacity = $request->capacity;
            if ($capacity === '1') {
                $query->where('capacity', 1);
            } elseif ($capacity === '2') {
                $query->where('capacity', 2);
            } elseif ($capacity === '3+') {
                $query->where('capacity', '>=', 3);
            }
        }

        // Tri
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name-asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name-desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'capacity-asc':
                    $query->orderBy('capacity', 'asc');
                    break;
                case 'capacity-desc':
                    $query->orderBy('capacity', 'desc');
                    break;
            }
        } else {
            // Tri par défaut si besoin
            $query->orderBy('name', 'asc');
        }

        $rooms = $query->latest()->paginate(10);
        $formations = Formation::all();

        return view('admin.rooms.index', compact('rooms', 'formations'));
    }

    public function create()
    {
        // if ($this->user && !$this->user->can('course.create')) {
        //     abort(403, 'Non autorisé');
        // }

        $formations = Formation::all();

        return view('admin.rooms.create', compact('formations'));
    }

    public function store(Request $request)
    {
        // if ($this->user && !$this->user->can('course.create')) {
        //     abort(403, 'Non autorisé');
        // }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'formation_id' => 'nullable|exists:formations,id',
        ]);

        $room = Room::create($validated);

        log_history('created', $room, ['before' => [], 'after' => $validated]);

        return redirect()->route('admin.rooms.index', ['locale' => app()->getLocale()])
            ->with('success', 'Salle créée avec succès.');
    }

    public function edit($locale, Room $room)
    {
        // if ($this->user && !$this->user->can('course.update')) {
        //     abort(403, 'Non autorisé');
        // }

        $formations = Formation::all();

        return view('admin.rooms.edit', compact('room', 'formations'));
    }

    public function update($locale, Request $request, Room $room)
    {
        // if ($this->user && !$this->user->can('course.update')) {
        //     abort(403, 'Non autorisé');
        // }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'formation_id' => 'nullable|exists:formations,id',
        ]);

        $room->update($validated);

        log_history('updated', $room, ['before' => $room->toArray(), 'after' => $validated]);

        return redirect()->route('admin.rooms.index', ['locale' => app()->getLocale()])
            ->with('success', 'Salle mise à jour avec succès.');
    }

    public function destroy($locale, Room $room)
    {
        // if ($this->user && !$this->user->can('course.delete')) {
        //     abort(403, 'Non autorisé');
        // }

        $room->delete();

        log_history('deleted', $room, ['before' => $room->toArray(), 'after' => []]);

        return redirect()->route('admin.rooms.index', ['locale' => app()->getLocale()])
            ->with('success', 'Salle supprimée avec succès.');
    }
}
