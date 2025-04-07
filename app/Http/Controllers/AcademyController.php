<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademyController extends Controller
{
    /**
     * Affiche la liste des académies
     */
    public function index()
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.view')) {
            abort(403, 'Non autorisé');
        }

        // Récupération des académies avec pagination
        $academies = Academy::latest()->paginate(10);
        
        return view('academies.index', compact('academies'));
    }

    /**
     * Affiche le formulaire de création d'une académie
     */
    public function create()
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.create')) {
            abort(403, 'Non autorisé');
        }
        
        // Récupération des utilisateurs qui peuvent être responsables d'académie
        $users = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['DA', 'DG-PREPAS']);
        })->get();
        
        return view('academies.create', compact('users'));
    }

    /**
     * Enregistre une nouvelle académie
     */
    public function store(Request $request)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.create')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:academies,name'],
            'description' => ['nullable', 'string'],
            'director_id' => ['nullable', 'exists:users,id'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);
        
        // Création de l'académie
        $academy = Academy::create([
            'name' => $request->name,
            'description' => $request->description,
            'director_id' => $request->director_id,
            'location' => $request->location,
            'created_by' => auth()->id(),
        ]);
        
        return redirect()->route('academies.index')
            ->with('success', 'Académie créée avec succès.');
    }

    /**
     * Affiche les détails d'une académie
     */
    public function show(Academy $academy)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.view')) {
            abort(403, 'Non autorisé');
        }
        
        // Récupération des départements associés à cette académie
        $departments = $academy->departments()->paginate(10);
        
        // Récupération du personnel assigné à cette académie
        $personnel = $academy->personnel()->paginate(10);
        
        return view('academies.show', compact('academy', 'departments', 'personnel'));
    }

    /**
     * Affiche le formulaire de modification d'une académie
     */
    public function edit(Academy $academy)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.update')) {
            abort(403, 'Non autorisé');
        }
        
        // Récupération des utilisateurs qui peuvent être responsables d'académie
        $users = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['DA', 'DG-PREPAS']);
        })->get();
        
        return view('academies.edit', compact('academy', 'users'));
    }

    /**
     * Met à jour une académie
     */
    public function update(Request $request, Academy $academy)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.update')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:academies,name,' . $academy->id],
            'description' => ['nullable', 'string'],
            'director_id' => ['nullable', 'exists:users,id'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);
        
        // Mise à jour de l'académie
        $academy->update([
            'name' => $request->name,
            'description' => $request->description,
            'director_id' => $request->director_id,
            'location' => $request->location,
            'updated_by' => auth()->id(),
        ]);
        
        return redirect()->route('academies.index')
            ->with('success', 'Académie mise à jour avec succès.');
    }

    /**
     * Supprime une académie
     */
    public function destroy(Academy $academy)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.delete')) {
            abort(403, 'Non autorisé');
        }
        
        // Vérifier si l'académie a des départements
        if ($academy->departments()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette académie car elle contient des départements.');
        }
        
        // Vérifier si l'académie a du personnel assigné
        if ($academy->personnel()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette académie car elle a du personnel assigné.');
        }
        
        // Suppression de l'académie
        $academy->delete();
        
        return redirect()->route('academies.index')
            ->with('success', 'Académie supprimée avec succès.');
    }

    /**
     * Affiche le formulaire pour assigner du personnel à une académie
     */
    public function assignPersonnelForm(Academy $academy)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('staff.assign')) {
            abort(403, 'Non autorisé');
        }
        
        // Récupération du personnel non assigné à cette académie
        $available_personnel = User::whereDoesntHave('academies', function($query) use ($academy) {
            $query->where('academy_id', $academy->id);
        })->get();
        
        return view('academies.assign_personnel', compact('academy', 'available_personnel'));
    }

    /**
     * Assigne du personnel à une académie
     */
    public function assignPersonnel(Request $request, Academy $academy)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('staff.assign')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $request->validate([
            'personnel' => ['required', 'array'],
            'personnel.*' => ['exists:users,id'],
        ]);
        
        // Assignation du personnel à l'académie
        $academy->personnel()->attach($request->personnel);
        
        return redirect()->route('academies.show', $academy)
            ->with('success', 'Personnel assigné avec succès à l\'académie.');
    }

    /**
     * Retire du personnel d'une académie
     */
    public function removePersonnel(Request $request, Academy $academy, User $user)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('staff.assign')) {
            abort(403, 'Non autorisé');
        }
        
        // Retirer l'utilisateur de l'académie
        $academy->personnel()->detach($user->id);
        
        return redirect()->route('academies.show', $academy)
            ->with('success', 'Personnel retiré avec succès de l\'académie.');
    }
}