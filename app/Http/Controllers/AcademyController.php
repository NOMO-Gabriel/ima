<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AcademyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('academy.view')) {
            abort(403, 'Accès non autorisé');
        }

        // Filtrage des académies
        $query = Academy::with(['director', 'creator', 'updater', 'users', 'formations']);

        // Recherche par texte
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtre par présence de directeur
        if ($request->filled('has_director')) {
            if ($request->has_director == '1') {
                $query->whereNotNull('director_id');
            } elseif ($request->has_director == '0') {
                $query->whereNull('director_id');
            }
        }

        // Tri
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $allowedSorts = ['name', 'code', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        // Pagination avec 10 éléments par page
        $academies = $query->paginate(10)->withQueryString();

        // Calcul des statistiques
        $allAcademies = Academy::all();

        // Académies avec directeur
        $academiesWithDirector = Academy::whereNotNull('director_id')->count();

        // Académies créées ce mois
        $recentAcademies = Academy::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Total des formations dans toutes les académies
        $totalFormations = Formation::count();

        return view('admin.academies.index', compact(
            'academies',
            'academiesWithDirector',
            'recentAcademies',
            'totalFormations'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Vérifier les permissions
        if (!Auth::user()->can('academy.create')) {
            abort(403, 'Accès non autorisé');
        }

        // Récupérer tous les utilisateurs qui peuvent être directeurs
        $directors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['dg-prepas', 'sg', 'da']);
        })->get();

        return view('admin.academies.create', compact('directors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('academy.create')) {
            abort(403, 'Accès non autorisé');
        }

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

        // Log de l'historique
        if (function_exists('log_history')) {
            log_history('created', $academy, [], 'Académie créée');
        }

        return redirect()->route('admin.academies.index', ['locale' => app()->getLocale()])
            ->with('success', 'Académie créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Academy $academy)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('academy.view')) {
            abort(403, 'Accès non autorisé');
        }

        $academy->load(['director', 'formations', 'departments', 'users']);

        // Statistiques spécifiques à cette académie
        $stats = [
            'formations_count' => $academy->formations->count(),
            'departments_count' => $academy->departments->count(),
            'users_count' => $academy->users->count(),
            'teachers_count' => $academy->teachers->count() ?? 0,
        ];

        return view('admin.academies.show', compact('academy', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Academy $academy)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('academy.update')) {
            abort(403, 'Accès non autorisé');
        }

        // Récupérer tous les utilisateurs qui peuvent être directeurs
        $directors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['dg-prepas', 'sg', 'da']);
        })->get();

        return view('admin.academies.edit', compact('academy', 'directors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Academy $academy)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('academy.update')) {
            abort(403, 'Accès non autorisé');
        }

        // Sauvegarder les anciennes valeurs pour l'historique
        $oldValues = $academy->toArray();

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

        // Log de l'historique
        if (function_exists('log_history')) {
            $changes = [
                'before' => $oldValues,
                'after' => $academy->fresh()->toArray()
            ];
            log_history('updated', $academy, $changes, 'Académie mise à jour');
        }

        return redirect()->route('admin.academies.index', ['locale' => app()->getLocale()])
            ->with('success', 'Académie mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Academy $academy)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('academy.delete')) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier si l'académie a des formations associées
        if ($academy->formations()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette académie car elle contient des formations.');
        }

        // Vérifier si l'académie a des départements associés
        if ($academy->departments()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette académie car elle contient des départements.');
        }

        // Vérifier si l'académie a des utilisateurs associés
        if ($academy->users()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer cette académie car elle contient des utilisateurs.');
        }

        // Sauvegarder les données pour l'historique
        $academyData = $academy->toArray();

        // Log de l'historique avant suppression
        if (function_exists('log_history')) {
            log_history('deleted', $academy, ['deleted_data' => $academyData], 'Académie supprimée');
        }

        // Supprimer l'académie (la table pivot sera automatiquement nettoyée grâce à onDelete('cascade'))
        $academy->delete();

        return redirect()->route('admin.academies.index', ['locale' => app()->getLocale()])
            ->with('success', 'Académie supprimée avec succès.');
    }

    /**
     * Export academies data (bonus method)
     */
    public function export(Request $request)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('academy.view')) {
            abort(403, 'Accès non autorisé');
        }

        $academies = Academy::with(['director', 'formations', 'departments'])
            ->get()
            ->map(function ($academy) {
                return [
                    'Nom' => $academy->name,
                    'Code' => $academy->code,
                    'Description' => $academy->description,
                    'Directeur' => $academy->director ?
                        $academy->director->first_name . ' ' . $academy->director->last_name :
                        'Non assigné',
                    'Formations' => $academy->formations->count(),
                    'Départements' => $academy->departments->count(),
                    'Date création' => $academy->created_at->format('d/m/Y'),
                ];
            });

        $filename = 'academies_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($academies) {
            $file = fopen('php://output', 'w');

            // BOM pour UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // En-têtes
            fputcsv($file, array_keys($academies->first()), ';');

            // Données
            foreach ($academies as $academy) {
                fputcsv($file, $academy, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
