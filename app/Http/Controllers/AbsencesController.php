<?php

namespace App\Http\Controllers;

use App\Models\Absences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsencesController extends Controller
{
    /** @var \App\Models\User|null */
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        if (!$this->user || !$this->user->can('absences.view')) {
            abort(403, 'Non autorisé');
        }

        $absences = Absences::with('student', 'slot')->latest()->get();

        return view('absences.index', compact('absences'));
    }

    public function create()
    {
        if (!$this->user || !$this->user->can('absences.create')) {
            abort(403, 'Non autorisé');
        }

        return view('absences.create');
    }

    public function store(Request $request)
    {
        if (!$this->user || !$this->user->can('absences.create')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:users,id'],
            'slot_id' => ['required', 'integer', 'exists:slots,id'],
        ]);

        Absences::create($validated);

        return redirect()->route('absences.index')
            ->with('success', 'Absences ajoutée avec succès.');
    }

    public function show(Absences $absence)
    {
        if (!$this->user || !$this->user->can('absences.view')) {
            abort(403, 'Non autorisé');
        }

        return view('absences.show', compact('absence'));
    }

    public function edit(Absences $absence)
    {
        if (!$this->user || !$this->user->can('absences.edit')) {
            abort(403, 'Non autorisé');
        }

        return view('absences.edit', compact('absence'));
    }

    public function update(Request $request, Absences $absence)
    {
        if (!$this->user || !$this->user->can('absences.edit')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:users,id'],
            'slot_id' => ['required', 'integer', 'exists:slots,id'],
        ]);

        $absence->update($validated);

        return redirect()->route('absences.index')
            ->with('success', 'Absences mise à jour avec succès.');
    }

    public function destroy(Absences $absence)
    {
        if (!$this->user || !$this->user->can('absences.delete')) {
            abort(403, 'Non autorisé');
        }

        $absence->delete();

        return redirect()->route('absences.index')
            ->with('success', 'Absences supprimée avec succès.');
    }
}
