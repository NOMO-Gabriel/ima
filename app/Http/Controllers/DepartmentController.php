<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.view')) {
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.create')) {
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.create')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:departments'],
            'description' => ['nullable', 'string'],
            'academy_id' => ['required', 'exists:academies,id'],
            'head_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        
        // Ajouter les champs de traçabilité
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        
        // Créer le département
        $department = Department::create($validated);
        
        return redirect()->route('departments.index')
            ->with('success', 'Département créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.view')) {
            abort(403, 'Non autorisé');
        }
        
        // Charger les relations
        $department->load(['academy', 'head']);
        
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.update')) {
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.update')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', Rule::unique('departments')->ignore($department->id)],
            'description' => ['nullable', 'string'],
            'academy_id' => ['required', 'exists:academies,id'],
            'head_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        
        // Ajouter le champ de traçabilité
        $validated['updated_by'] = Auth::id();
        
        // Mettre à jour le département
        $department->update($validated);
        
        return redirect()->route('departments.index')
            ->with('success', 'Département mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.delete')) {
            abort(403, 'Non autorisé');
        }
        
        // Supprimer le département
        $department->delete();
        
        return redirect()->route('departments.index')
            ->with('success', 'Département supprimé avec succès.');
    }
}