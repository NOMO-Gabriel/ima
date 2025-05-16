<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\User;
use App\Models\Academy;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CenterController extends Controller
{
    /**
     * Affiche la liste des centres
     */
    public function index()
    {
        // Vérifier les permissions
        if (!Auth::user()->can('center.view')) {
            abort(403, 'Non autorisé');
        }

        $centers = Center::with(['academy', 'staff'])->get();
        return view('admin.centers.index', compact('centers'));
    }

    /**
     * Affiche le formulaire de création d'un centre
     */
    public function create()
    {
        // Vérifier les permissions
        if (!Auth::user()->can('center.create')) {
            abort(403, 'Non autorisé');
        }

        // Récupérer les utilisateurs qui peuvent être directeurs
        $directors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['DA', 'DG-PREPAS', 'SG', 'PCA']);
        })->get();

        $cities = City::all();

        $academies = Academy::all();
        return view('admin.centers.create', compact('academies', 'directors', 'cities'));
    }

    /**
     * Enregistre un nouveau centre
     */
    public function store(Request $request)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('center.create')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['nullable', 'string', 'max:50', 'unique:centers'],
            'description' => 'nullable|string',
            'academy_id' => 'required|exists:academies,id',
            'city_id' => ['required', 'exists:cities,id'],
            'address' => 'required|string|max:255',
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'director_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $center = Center::create($validated);

        return redirect()->route('admin.centers.index', ['locale' => app()->getLocale()])
            ->with('success', 'Centre créé avec succès.');
    }

    /**
     * Affiche les détails d'un centre
     */
    public function show(Center $center)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('center.view')) {
            abort(403, 'Non autorisé');
        }

        $center->load(['academy', 'staff', 'rooms', 'courses']);
        return view('admin.centers.show', compact('center'));
    }

    /**
     * Affiche le formulaire de modification d'un centre
     */
    public function edit(Center $center)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('center.update')) {
            abort(403, 'Non autorisé');
        }

        $academies = Academy::all();
        return view('admin.centers.edit', compact('center', 'academies'));
    }

    /**
     * Met à jour un centre
     */
    public function update(Request $request, Center $center)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('center.update')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'capacity' => 'required|integer|min:1',
            'academy_id' => 'required|exists:academies,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $center->update($validated);

        return redirect()->route('admin.centers.index', ['locale' => app()->getLocale()])
            ->with('success', 'Centre mis à jour avec succès.');
    }

    /**
     * Supprime un centre
     */
    public function destroy(Center $center)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('center.delete')) {
            abort(403, 'Non autorisé');
        }

        // Vérifier si le centre a des cours ou du personnel assigné
        if ($center->courses()->count() > 0 || $center->staff()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce centre car il contient des cours ou du personnel.');
        }

        $center->delete();

        return redirect()->route('admin.centers.index')
            ->with('success', 'Centre supprimé avec succès.');
    }

    /**
     * Affiche la page d'assignation du personnel à un centre
     */
    public function assignStaff(Center $center)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('staff.assign')) {
            abort(403, 'Non autorisé');
        }

        $staffMembers = User::role(['Personnel-Centre', 'Resp-Academique', 'Resp-Financier', 'Resp-Logistique'])
            ->where('status', 'active')
            ->get();

        $assignedStaff = $center->staff()->pluck('user_id')->toArray();

        return view('admin.centers.assign-staff', compact('center', 'staffMembers', 'assignedStaff'));
    }

    /**
     * Enregistre l'assignation du personnel à un centre
     */
    public function storeAssignStaff(Request $request, Center $center)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('staff.assign')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'staff' => 'required|array',
            'staff.*' => 'exists:users,id'
        ]);

        // Mettre à jour les assignations
        $center->staff()->sync($validated['staff']);

        return redirect()->route('admin.centers.show', ['locale' => app()->getLocale(), 'center' => $center])
            ->with('success', 'Personnel assigné avec succès.');
    }
}
