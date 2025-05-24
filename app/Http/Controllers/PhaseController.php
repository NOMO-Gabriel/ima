<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    public function index()
    {
        $phases = Phase::all();
        return view('admin.phases.index', compact('phases'));
    }

    public function create()
    {
        return view('admin.phases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        Phase::create($validated);

        return redirect()->route('admin.phases.index', ['locale' => app()->getLocale()])
            ->with('success', 'Phase créée avec succès.');
    }

    public function show($locale, Phase $phase)
    {
        return view('admin.phases.show', compact('phase'));
    }

    public function edit($locale, Phase $phase)
    {
        return view('admin.phases.edit', compact('phase'));
    }

    public function update($locale, Request $request, Phase $phase)
    {
        $validated = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $phase->update($validated);

        return redirect()->route('admin.phases.index', ['locale' => app()->getLocale()])
            ->with('success', 'Phase mise à jour avec succès.');
    }

    public function destroy($locale, Phase $phase)
    {
        $phase->delete();

        return redirect()->route('admin.phases.index', ['locale' => app()->getLocale()])
            ->with('success', 'Phase supprimée avec succès.');
    }
}
