<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        // if ($this->user && !$this->user->can('course.view')) {
        //     abort(403, 'Non autorisé');
        // }

        $cities = City::all();

        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        // if ($this->user && !$this->user->can('course.create')) {
        //     abort(403, 'Non autorisé');
        // }

        return view('admin.cities.create');
    }

    public function store(Request $request)
    {
        // if ($this->user && !$this->user->can('course.create')) {
        //     abort(403, 'Non autorisé');
        // }

        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:cities',
        ]);

        City::create($validated);

        return redirect()->route('admin.cities.index', ['locale' => app()->getLocale()])
            ->with('success', 'La ville a été créé avec succès !');
    }

    public function edit($locale, City $city)
    {
        // if ($this->user && !$this->user->can('course.update')) {
        //     abort(403, 'Non autorisé');
        // }

        return view('admin.cities.edit', compact('city'));
    }

    public function update($locale, Request $request, City $city)
    {
        // if ($this->user && !$this->user->can('course.update')) {
        //     abort(403, 'Non autorisé');
        // }

        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:cities',
        ]);

        $city->update($validated);

        return redirect()->route('admin.cities.index', ['locale' => app()->getLocale()])
            ->with('success', 'Ville mise à jour avec succès.');
    }

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
