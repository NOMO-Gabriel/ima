<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AcademyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.view')) {
            abort(403, 'Non autorisé');
        }

        // Filtrage des académies
        $query = Academy::query();
        
        // Recherche par texte
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        // Filtrer par statut
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? true : false;
            $query->where('is_active', $status);
        }
        
        // Récupération des académies paginées
        $academies = $query->with(['director', 'departments'])->latest()->paginate(10);
        
        return view('academies.index', compact('academies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.create')) {
            abort(403, 'Non autorisé');
        }
        
        // Récupérer les utilisateurs qui peuvent être directeurs
        $directors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['DA', 'DG-PREPAS', 'SG', 'PCA']);
        })->get();
        
        return view('academies.create', compact('directors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.create')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:academies'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'director_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        
        // Ajouter les champs de traçabilité
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        
        // Créer l'académie
        $academy = Academy::create($validated);
        
        return redirect()->route('academies.index')
            ->with('success', 'Académie créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Academy $academy)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.view')) {
            abort(403, 'Non autorisé');
        }
        
        // Charger les relations
        $academy->load(['director', 'departments', 'centers']);
        
        return view('academies.show', compact('academy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Academy $academy)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.update')) {
            abort(403, 'Non autorisé');
        }
        
        // Récupérer les utilisateurs qui peuvent être directeurs
        $directors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['DA', 'DG-PREPAS', 'SG', 'PCA']);
        })->get();
        
        return view('academies.edit', compact('academy', 'directors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Academy $academy)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.update')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', Rule::unique('academies')->ignore($academy->id)],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'director_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        
        // Ajouter le champ de traçabilité
        $validated['updated_by'] = Auth::id();
        
        // Mettre à jour l'académie
        $academy->update($validated);
        
        return redirect()->route('academies.index')
            ->with('success', 'Académie mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Academy $academy)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('academy.delete')) {
            abort(403, 'Non autorisé');
        }
        
        // Vérifier si l'académie a des départements
        if ($academy->departments()->count() > 0 || $academy->centers()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette académie car elle contient des départements ou des centres.');
        }
        
        // Supprimer l'académie
        $academy->delete();
        
        return redirect()->route('academies.index')
            ->with('success', 'Académie supprimée avec succès.');
    }
}