<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    protected $units;

    public function __construct()
    {
        $this->units = [
            'pcs' => 'Pièces',
            'kg' => 'Kilogrammes',
            'g' => 'Grammes',
            'm' => 'Mètres',
            'cm' => 'Centimètres',
            'mm' => 'Millimètres',
            'l' => 'Litres',
            'ml' => 'Millilitres',
            'm2' => 'Mètres carrés',
            'm3' => 'Mètres cubes',
            'set' => 'Ensembles',
            'box' => 'Boîtes',
            'pack' => 'Paquets',
        ];
    }

    public function index()
    {
        $materials = Material::all();
        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        $units = $this->units;
        return view('admin.materials.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|in:pcs,kg,g,m,cm,mm,l,ml,m2,m3,set,box,pack',
            'quantity' => 'required|integer|min:0',
        ]);

        Material::create($validated);

        return redirect()->route('admin.materials.index', ['locale' => app()->getLocale()])
            ->with('success', 'Matériel créé avec succès.');
    }

    public function show($locale, Material $material)
    {
        return view('admin.materials.show', compact('material'));
    }

    public function edit($locale, Material $material)
    {
        $units = $this->units;
        return view('admin.materials.edit', compact('material', 'units'));
    }

    public function update($locale, Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|in:pcs,kg,g,m,cm,mm,l,ml,m2,m3,set,box,pack',
            'quantity' => 'required|integer|min:0',
        ]);

        $material->update($validated);

        return redirect()->route('admin.materials.index', ['locale' => app()->getLocale()])
            ->with('success', 'Matériel mis à jour avec succès.');
    }

    public function destroy($locale, Material $material)
    {
        $material->delete();

        return redirect()->route('admin.materials.index', ['locale' => app()->getLocale()])
            ->with('success', 'Matériel supprimé avec succès.');
    }
}
