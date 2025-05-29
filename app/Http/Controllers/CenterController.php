<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Center;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    // Afficher la liste des centers
    public function index()
    {
        $centers = Center::paginate(15);
        return view('admin.centers.index', compact('centers'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        $cities = City::all();
        $users = User::all();
        $academies = Academy::all();

        return view('admin.centers.create', compact('cities', 'users', 'academies'));
    }

    // Stocker un nouveau center
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:centers',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'staff_ids' => 'nullable|json',
            'city_id' => 'nullable|exists:cities,id',
            'director_id' => 'nullable|exists:users,id',
            'logistics_director_id' => 'nullable|exists:users,id',
            'finance_director_id' => 'nullable|exists:users,id',
            'academy_id' => 'nullable|exists:academies,id',
        ]);

        $data['created_by'] = $this->user->id;

        Center::create($data);

        return redirect()->route('admin.centers.index', app()->getLocale())
            ->with('success', 'Centre créé avec succès.');
    }

    // Afficher un center
    public function show($locale, Center $center)
    {
        return view('admin.centers.show', compact('center'));
    }

    // Formulaire d'édition
    public function edit($locale, Center $center)
    {
        $cities = City::all();
        $users = User::all();
        $academies = Academy::all();

        return view('admin.centers.edit', compact('center', 'cities', 'users', 'academies'));
    }

    // Mettre à jour un center
    public function update($locale, Request $request, Center $center)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:centers,code,' . $center->id,
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'staff_ids' => 'nullable|json',
            'city_id' => 'nullable|exists:cities,id',
            'director_id' => 'nullable|exists:users,id',
            'logistics_director_id' => 'nullable|exists:users,id',
            'finance_director_id' => 'nullable|exists:users,id',
            'academy_id' => 'nullable|exists:academies,id',
        ]);

        $data['updated_by'] = $this->user->id;

        $center->update($data);

        return redirect()->route('admin.centers.index', app()->getLocale())
            ->with('success', 'Centre mis à jour avec succès.');
    }

    // Supprimer un center
    public function destroy($locale, Center $center)
    {
        $center->delete();
        return redirect()->route('admin.centers.index', app()->getLocale())
            ->with('success', 'Centre supprimé avec succès.');
    }
}
