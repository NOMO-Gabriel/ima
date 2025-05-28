<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Material;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index()
    {
        $commands = Command::with('user', 'commandUnits.material')->get();
        return view('admin.commands.index', compact('commands'));
    }

    public function create()
    {
        $materials = Material::all();
        return view('admin.commands.create', compact('materials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'units' => 'required|array',
            'units.*.material_id' => 'required|exists:materials,id',
            'units.*.quantity' => 'required|integer|min:0',
        ]);

        $totalQuantity = collect($validated['units'])->sum('quantity');

        $command = Command::create([
            'quantity' => $totalQuantity,
            'user_id' => $this->user->id,
        ]);

        foreach ($validated['units'] as $unit) {
            $command->commandUnits()->create([
                'material_id' => $unit['material_id'],
                'quantity' => $unit['quantity'],
            ]);
        }

        return redirect()->route('admin.commands.index')->with('success', 'Commande créée avec succès.');
    }


    public function show(Command $command)
    {
        $command->load('user', 'commandUnits.material');
        return view('admin.commands.show', compact('command'));
    }

    public function edit(Command $command)
    {
        $materials = Material::all();
        $command->load('commandUnits');
        return view('admin.commands.edit', compact('command', 'materials'));
    }

    public function update(Request $request, Command $command)
    {
        $validated = $request->validate([
            'units' => 'required|array',
            'units.*.id' => 'nullable|exists:command_units,id',
            'units.*.material_id' => 'required|exists:materials,id',
            'units.*.quantity' => 'required|integer|min:0',
        ]);

        $totalQuantity = collect($validated['units'])->sum('quantity');

        $command->update([
            'quantity' => $totalQuantity,
            'user_id' => $this->user->id,
        ]);

        $command->commandUnits()->delete();

        foreach ($validated['units'] as $unit) {
            $command->commandUnits()->create([
                'material_id' => $unit['material_id'],
                'quantity' => $unit['quantity'],
            ]);
        }

        return redirect()->route('admin.commands.index')->with('success', 'Commande mise à jour avec succès.');
    }

    public function destroy(Command $command)
    {
        $command->delete();
        return redirect()->route('admin.commands.index')->with('success', 'Commande supprimée avec succès.');
    }
}
