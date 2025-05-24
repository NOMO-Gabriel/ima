<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\User;
use App\Models\Academy;
use App\Models\City;
use App\Models\Slot;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CenterController extends Controller
{
    public function index()
    {
        // Vérifier les permissions
        if ($this->user && !$this->user->can('center.view')) {
            abort(403, 'Non autorisé');
        }

        $centers = Center::with(['academy', 'staff'])->get();
        return view('admin.centers.index', compact('centers'));
    }

    public function create()
    {
        if ($this->user && !$this->user->can('center.create')) {
            abort(403, 'Non autorisé');
        }

        $directors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['DA', 'DG-PREPAS', 'SG', 'PCA']);
        })->get();

        $cities = City::all();
        $academies = Academy::all();

        return view('admin.centers.create', compact('academies', 'directors', 'cities'));
    }

    public function store(Request $request)
    {
        if ($this->user && !$this->user->can('center.create')) {
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

        // Find the start of week to display
        if ($request->filled('week_start_date')) {
            $weekStart = Carbon::parse($request->input('week_start_date'))->startOfWeek();
        } else {
            $weekStart = Carbon::now()->startOfWeek();
        }

        Timetable::createWithDefaultSlots($center, $weekStart);

        return redirect()->route('admin.centers.index', ['locale' => app()->getLocale()])
            ->with('success', 'Centre créé avec succès.');
    }

    /**
     * Affiche les détails d'un centre
     */
    public function show($locale, Center $center)
    {
        // Vérifier les permissions
        if ($this->user && !$this->user->can('center.view')) {
            abort(403, 'Non autorisé');
        }

        $center->load(['academy']);
        return view('admin.centers.show', compact('center'));
    }

    /**
     * Affiche le formulaire de modification d'un centre
     */
    public function edit($locale, Center $center)
    {
        // Vérifier les permissions
        if ($this->user && !$this->user->can('center.update')) {
            abort(403, 'Non autorisé');
        }

        $directors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['DA', 'DG-PREPAS', 'SG', 'PCA']);
        })->get();

        $cities = City::all();
        $academies = Academy::all();

        return view('admin.centers.edit', compact('center', 'academies', 'directors', 'cities'));
    }

    /**
     * Met à jour un centre
     */
    public function update($locale, Request $request, Center $center)
    {
        // Vérifier les permissions
        if ($this->user && !$this->user->can('center.update')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['nullable', 'string', 'max:50', Rule::unique('centers')->ignore($center->id)],
            'description' => 'nullable|string',
            'academy_id' => 'required|exists:academies,id',
            'city_id' => ['required', 'exists:cities,id'],
            'address' => 'required|string|max:255',
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'director_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $center->update($validated);

        return redirect()->route('admin.centers.index', ['locale' => app()->getLocale()])
            ->with('success', 'Centre mis à jour avec succès.');
    }

    /**
     * Supprime un centre
     */
    public function destroy($locale, Center $center)
    {
        if ($this->user && !$this->user->can('center.delete')) {
            abort(403, 'Non autorisé');
        }

        $center->delete();

        return redirect()->route('admin.centers.index', ['locale' => app()->getLocale()])
            ->with('success', 'Centre supprimé avec succès.');
    }

    /**
     * Affiche la page d'assignation du personnel à un centre
     */
    public function assignStaff(Center $center)
    {
        // Vérifier les permissions
        if ($this->user && !$this->user->can('staff.assign')) {
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
        if ($this->user && !$this->user->can('staff.assign')) {
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
