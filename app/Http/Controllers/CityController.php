<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if ($this->user && !$this->user->can('course.view')) {
        //     abort(403, 'Non autorisé');
        // }

        $cities = City::all();

        return view('admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if ($this->user && !$this->user->can('course.create')) {
        //     abort(403, 'Non autorisé');
        // }

        return view('admin.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if ($this->user && !$this->user->can('course.create')) {
        //     abort(403, 'Non autorisé');
        // }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cities',
        ]);

        City::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.cities.index', ['locale' => app()->getLocale()])
            ->with('success', 'La ville a été créé avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, City $city)
    {
        // if ($this->user && !$this->user->can('course.update')) {
        //     abort(403, 'Non autorisé');
        // }

        return view('admin.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, City $city)
    {
        // if ($this->user && !$this->user->can('course.update')) {
        //     abort(403, 'Non autorisé');
        // }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cities',
        ]);

        $city->update($validated);

        return redirect()->route('admin.cities.index', ['locale' => app()->getLocale()])
            ->with('success', 'Ville mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, City $city)
    {
        // if ($this->user && !$this->user->can('course.delete')) {
        //     abort(403, 'Non autorisé');
        // }

        $city->delete();

        return redirect()->route('admin.cities.index', ['locale' => app()->getLocale()])
            ->with('success', 'Ville supprimée avec succès.');
    }
}
