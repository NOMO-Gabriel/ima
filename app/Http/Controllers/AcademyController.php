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
        // Filtrage des académies
        $query = Academy::query();

        // Recherche par texte
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Récupération des académies paginées avec leurs relations
        $academies = $query->with(['director', 'creator', 'updater', 'users'])
                          ->latest()
                          ->paginate(10);

        return view('admin.academies.index', compact('academies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer tous les utilisateurs qui peuvent être directeurs
        $directors = User::all();

        return view('admin.academies.create', compact('directors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:academies'],
            'description' => ['nullable', 'string'],
            'director_id' => ['nullable', 'exists:users,id'],
        ]);

        // Ajouter les champs de traçabilité
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        // Créer l'académie
        $academy = Academy::create($validated);

        // Si un directeur est assigné, l'ajouter comme membre avec le rôle 'director'
        if ($validated['director_id']) {
            $academy->users()->attach($validated['director_id'], [
                'role' => 'director',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('admin.academies.index', ['locale' => app()->getLocale()])
            ->with('success', 'Académie créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($locale,Academy $academy)
    {
        return view('admin.academies.show', compact('academy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Academy $academy)
    {
        // Récupérer tous les utilisateurs qui peuvent être directeurs
        $directors = User::all();

        return view('admin.academies.edit', compact('academy', 'directors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Academy $academy)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', Rule::unique('academies')->ignore($academy->id)],
            'description' => ['nullable', 'string'],
            'director_id' => ['nullable', 'exists:users,id'],
        ]);

        // Ajouter le champ de traçabilité
        $validated['updated_by'] = Auth::id();

        // Gérer le changement de directeur
        $oldDirectorId = $academy->director_id;
        $newDirectorId = $validated['director_id'];

        // Mettre à jour l'académie
        $academy->update($validated);

        // Gérer les relations dans la table pivot
        if ($oldDirectorId !== $newDirectorId) {
            // Retirer l'ancien directeur du rôle 'director' s'il existe
            if ($oldDirectorId) {
                $academy->users()->updateExistingPivot($oldDirectorId, ['role' => 'member']);
            }

            // Ajouter le nouveau directeur
            if ($newDirectorId) {
                // Vérifier s'il est déjà membre
                if ($academy->users()->where('user_id', $newDirectorId)->exists()) {
                    $academy->users()->updateExistingPivot($newDirectorId, ['role' => 'director']);
                } else {
                    $academy->users()->attach($newDirectorId, [
                        'role' => 'director',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        return redirect()->route('admin.academies.index', ['locale' => app()->getLocale()])
            ->with('success', 'Académie mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale , Academy $academy)
    {
        // Vérifier si l'académie a des utilisateurs associés
        if ($academy->users()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette académie car elle contient des utilisateurs.');
        }

        // Supprimer l'académie (la table pivot sera automatiquement nettoyée grâce à onDelete('cascade'))
        $academy->delete();

        return redirect()->route('admin.academies.index', ['locale' => app()->getLocale()])
            ->with('success', 'Académie supprimée avec succès.');
    }

    // /**
    //  * Afficher les utilisateurs d'une académie
    //  */
    // public function users(Academy $academy)
    // {
    //     $users = $academy->users()->withPivot('role')->orderBy('name')->paginate(15);

    //     return view('admin.academies.users', compact('academy', 'users'));
    // }

    // /**
    //  * Ajouter un utilisateur à une académie
    //  */
    // public function addUser(Request $request, Academy $academy)
    // {
    //     $validated = $request->validate([
    //         'user_id' => ['required', 'exists:users,id'],
    //         'role' => ['required', 'string', 'in:member,admin,director']
    //     ]);

    //     // Vérifier si l'utilisateur n'est pas déjà membre
    //     if ($academy->users()->where('user_id', $validated['user_id'])->exists()) {
    //         return back()->with('error', 'Cet utilisateur est déjà membre de cette académie.');
    //     }

    //     // Si le rôle est directeur, s'assurer qu'il n'y en a qu'un seul
    //     if ($validated['role'] === 'director') {
    //         // Retirer le rôle director des autres utilisateurs
    //         $academy->users()->wherePivot('role', 'director')->updateExistingPivot(
    //             $academy->users()->wherePivot('role', 'director')->pluck('user_id')->toArray(),
    //             ['role' => 'member']
    //         );

    //         // Mettre à jour le director_id dans la table academies
    //         $academy->update(['director_id' => $validated['user_id']]);
    //     }

    //     // Attacher l'utilisateur
    //     $academy->users()->attach($validated['user_id'], [
    //         'role' => $validated['role'],
    //         'created_at' => now(),
    //         'updated_at' => now()
    //     ]);

    //     return back()->with('success', 'Utilisateur ajouté avec succès.');
    // }

    // /**
    //  * Modifier le rôle d'un utilisateur dans une académie
    //  */
    // public function updateUserRole(Request $request, Academy $academy, User $user)
    // {
    //     $validated = $request->validate([
    //         'role' => ['required', 'string', 'in:member,admin,director']
    //     ]);

    //     // Vérifier que l'utilisateur est membre de cette académie
    //     if (!$academy->users()->where('user_id', $user->id)->exists()) {
    //         return back()->with('error', 'Cet utilisateur n\'est pas membre de cette académie.');
    //     }

    //     // Si le nouveau rôle est directeur
    //     if ($validated['role'] === 'director') {
    //         // Retirer le rôle director des autres utilisateurs
    //         $academy->users()->wherePivot('role', 'director')->updateExistingPivot(
    //             $academy->users()->wherePivot('role', 'director')->pluck('user_id')->toArray(),
    //             ['role' => 'member']
    //         );

    //         // Mettre à jour le director_id dans la table academies
    //         $academy->update(['director_id' => $user->id]);
    //     }

    //     // Si l'ancien rôle était directeur et le nouveau ne l'est pas
    //     $currentRole = $academy->users()->where('user_id', $user->id)->first()->pivot->role;
    //     if ($currentRole === 'director' && $validated['role'] !== 'director') {
    //         $academy->update(['director_id' => null]);
    //     }

    //     // Mettre à jour le rôle
    //     $academy->users()->updateExistingPivot($user->id, [
    //         'role' => $validated['role'],
    //         'updated_at' => now()
    //     ]);

    //     return back()->with('success', 'Rôle mis à jour avec succès.');
    // }

    // /**
    //  * Retirer un utilisateur d'une académie
    //  */
    // public function removeUser(Academy $academy, User $user)
    // {
    //     // Vérifier que l'utilisateur est membre de cette académie
    //     if (!$academy->users()->where('user_id', $user->id)->exists()) {
    //         return back()->with('error', 'Cet utilisateur n\'est pas membre de cette académie.');
    //     }

    //     // Si l'utilisateur était directeur, mettre à jour director_id
    //     $currentRole = $academy->users()->where('user_id', $user->id)->first()->pivot->role;
    //     if ($currentRole === 'director') {
    //         $academy->update(['director_id' => null]);
    //     }

    //     // Détacher l'utilisateur
    //     $academy->users()->detach($user->id);

    //     return back()->with('success', 'Utilisateur retiré avec succès.');
    // }
}
