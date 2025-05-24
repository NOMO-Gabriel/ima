<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        // if ($this->user && !$this->user->can('course.view')) {
        //     abort(403, 'Non autorisé');
        // }

        $rooms = Room::with('formation')->get();

        return view('admin.rooms.index', compact('rooms'));
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

        Room::create($validated);

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

        return redirect()->route('admin.rooms.index', ['locale' => app()->getLocale()])
            ->with('success', 'Salle mise à jour avec succès.');
    }

    public function destroy($locale, Room $room)
    {
        // if ($this->user && !$this->user->can('course.delete')) {
        //     abort(403, 'Non autorisé');
        // }

        $room->delete();

        return redirect()->route('admin.rooms.index', ['locale' => app()->getLocale()])
            ->with('success', 'Salle supprimée avec succès.');
    }
}
