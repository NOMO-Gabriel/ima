<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Phase;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($this->user && !$this->user->can('formation.view')) {
            abort(403, 'Non autorisé');
        }

        $formations = Formation::latest()->paginate(10);
        return view('admin.formations.index', compact('formations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if ($this->user && !$this->user->can('formation.create')) {
            abort(403, 'Non autorisé');
        }

        $phases = Phase::all();
        return view('admin.formations.create', compact('phases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->user && !$this->user->can('formation.create')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|integer',
            'hours' => 'nullable|integer',
            'phase_id' => 'nullable|integer|exists:phases,id',
        ]);

        Formation::create($validated);

        return redirect()->route('admin.formations.index', ['locale' => app()->getLocale()])
            ->with('success', 'Formation créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Formation $formation)
    {
        if ($this->user && !$this->user->can('formation.view')) {
            abort(403, 'Non autorisé');
        }

        return view('admin.formations.show', compact('formation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Formation $formation)
    {
        if ($this->user && !$this->user->can('formation.update')) {
            abort(403, 'Non autorisé');
        }

        $phases = Phase::all();

        return view('admin.formations.edit', compact('formation', 'phases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Formation $formation)
    {
        if ($this->user && !$this->user->can('formation.update')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|integer',
            'hours' => 'nullable|integer',
            'phase_id' => 'nullable|integer|exists:phases,id',
        ]);

        $formation->update($validated);

        return redirect()->route('admin.formations.index', ['locale' => app()->getLocale()])
            ->with('success', 'Formation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Formation $formation)
    {
        if ($this->user && !$this->user->can('center.delete')) {
            abort(403, 'Non autorisé');
        }

        $formation->delete();

        return redirect()->route('admin.formations.index', ['locale' => app()->getLocale()])
            ->with('success', 'Formation supprimée avec succès.');
    }
}
