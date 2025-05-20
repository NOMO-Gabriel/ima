<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        // if ($this->user && !$this->user->can('course.view')) {
        //     abort(403, 'Non autorisé');
        // }

        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        // if ($this->user && !$this->user->can('course.create')) {
        //     abort(403, 'Non autorisé');
        // }

        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->user && !$this->user->can('course.create')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
        ]);

        $room = Room::create([
            'name' => $validated['name'],
            'capacity' => $validated['capacity'],
        ]);

        return redirect()->route('admin.rooms.index', ['locale' => app()->getLocale()])
            ->with('success', 'Salle créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Room $room)
    {
        // if ($this->user && !$this->user->can('course.view')) {
        //     abort(403, 'Non autorisé');
        // }

        return view('admin.courses.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Room $room)
    {
        // if ($this->user && !$this->user->can('course.update')) {
        //     abort(403, 'Non autorisé');
        // }

        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Room $room)
    {
        // if ($this->user && !$this->user->can('course.update')) {
        //     abort(403, 'Non autorisé');
        // }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
        ]);

        $room->update($validated);

        return redirect()->route('admin.rooms.index', ['locale' => app()->getLocale()])
            ->with('success', 'Salle mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
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
