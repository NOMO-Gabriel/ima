<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();

        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        return view('admin.cities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:cities',
        ]);

        $city = City::create($validated);

        log_history('created', $city, ['before' => [], 'after' => $validated]);

        return redirect()->route('admin.cities.index', ['locale' => app()->getLocale()])
            ->with('success', 'La ville a été créé avec succès !');
    }

    public function edit($locale, City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    public function update($locale, Request $request, City $city)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:cities',
        ]);

        $city->update($validated);

        log_history('updated', $city, ['before' => $city->toArray(), 'after' => $validated]);

        return redirect()->route('admin.cities.index', ['locale' => app()->getLocale()])
            ->with('success', 'Ville mise à jour avec succès.');
    }

    public function destroy($locale, City $city)
    {
        $city->delete();

        log_history('deleted', $city, ['before' => $city->toArray(), 'after' => []]);

        return redirect()->route('admin.cities.index', ['locale' => app()->getLocale()])
            ->with('success', 'Ville supprimée avec succès.');
    }
}
