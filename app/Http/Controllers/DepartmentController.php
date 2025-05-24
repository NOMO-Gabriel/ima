<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($this->user && !$this->user->can('department.view')) {
            abort(403, 'Non autorisé');
        }

        // Filtrage des départements
        $query = Department::query();

        // Filtrer par académie
        if ($request->filled('academy_id')) {
            $query->where('academy_id', $request->academy_id);
        }

        // Recherche par texte
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? true : false;
            $query->where('is_active', $status);
        }

        // Récupération des départements paginés
        $departments = $query->with(['academy', 'head'])->latest()->paginate(10);

        // Récupérer toutes les académies pour le filtre
        $academies = Academy::where('is_active', true)->get();

        return view('departments.index', compact('departments', 'academies'));
    }

    public function create()
    {
        if ($this->user && !$this->user->can('department.create')) {
            abort(403, 'Non autorisé');
        }

        // Récupérer les académies actives
        $academies = Academy::where('is_active', true)->get();

        // Récupérer les utilisateurs qui peuvent être chefs de département
        $heads = User::whereHas('roles', function($query) {
            $query->where('name', 'Chef-Departement');
        })->get();

        return view('departments.create', compact('academies', 'heads'));
    }

    public function store(Request $request)
    {
        if ($this->user && !$this->user->can('department.create')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:departments'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Département créé avec succès.');
    }

    public function show(Department $department)
    {
        if ($this->user && !$this->user->can('department.view')) {
            abort(403, 'Non autorisé');
        }

        // Charger les relations
        $department->load(['academy', 'head']);

        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        if ($this->user && !$this->user->can('department.update')) {
            abort(403, 'Non autorisé');
        }

        // Récupérer les académies actives
        $academies = Academy::where('is_active', true)->get();

        // Récupérer les utilisateurs qui peuvent être chefs de département
        $heads = User::whereHas('roles', function($query) {
            $query->where('name', 'Chef-Departement');
        })->get();

        return view('departments.edit', compact('department', 'academies', 'heads'));
    }

    public function update(Request $request, Department $department)
    {
        if ($this->user && !$this->user->can('department.update')) {
            abort(403, 'Non autorisé');
        }

        // Validation des données
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:departments'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy(Department $department)
    {
        if ($this->user && !$this->user->can('department.delete')) {
            abort(403, 'Non autorisé');
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Département supprimé avec succès.');
    }
}