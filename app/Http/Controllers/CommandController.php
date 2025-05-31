<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Command;
use App\Models\Material;
use App\Models\City;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandController extends Controller
{
    /**
     * Store a newly created command in storage.
     */
    public function store(Request $request, Material $material)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'direction' => 'required|in:in,out',
            'city_id' => 'nullable|exists:cities,id',
            'center_id' => 'nullable|exists:centers,id',
            'notes' => 'nullable|string|max:500',
        ]);

        // Vérification du stock pour les sorties
        if ($validated['direction'] === 'out' && $validated['quantity'] > $material->stock) {
            return redirect()
                ->back()
                ->with('error', 'Stock insuffisant ! Stock disponible : ' . $material->stock);
        }

        DB::transaction(function () use ($validated, $material) {
            // Créer la commande
            $command = Command::create([
                'quantity' => $validated['quantity'],
                'direction' => $validated['direction'],
                'material_id' => $material->id,
                'user_id' => Auth::id(),
                'city_id' => $validated['city_id'] ?? null,
                'center_id' => $validated['center_id'] ?? null,
            ]);

            // Mettre à jour le stock
            if ($validated['direction'] === 'in') {
                $material->increment('stock', $validated['quantity']);
            } else {
                $material->decrement('stock', $validated['quantity']);
            }
        });

        $directionText = $validated['direction'] === 'in' ? 'entrée' : 'sortie';

        return redirect()
            ->route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material->id])
            ->with('success', "Commande d'{$directionText} enregistrée avec succès !");
    }

    /**
     * Display the specified command.
     */
    public function show($locale, Command $command)
    {
        $command->load(['material', 'user', 'city', 'center']);

        return response()->json([
            'id' => $command->id,
            'quantity' => $command->quantity,
            'direction' => $command->direction,
            'direction_text' => $command->direction === 'in' ? 'Entrée' : 'Sortie',
            'material' => $command->material->name,
            'user' => $command->user->name,
            'city' => $command->city->name ?? 'N/A',
            'center' => $command->center->name ?? 'N/A',
            'created_at' => $command->created_at->format('d/m/Y H:i'),
            'formatted_date' => $command->created_at->diffForHumans(),
        ]);
    }

    /**
     * Remove the specified command from storage.
     */
    public function destroy($locale, Command $command)
    {
        $material = $command->material;

        DB::transaction(function () use ($command, $material) {
            // Annuler l'impact sur le stock
            if ($command->direction === 'in') {
                $material->decrement('stock', $command->quantity);
            } else {
                $material->increment('stock', $command->quantity);
            }

            $command->delete();
        });

        return redirect()
            ->route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material->id])
            ->with('success', 'Commande supprimée et stock ajusté avec succès !');
    }

    /**
     * Get cities for AJAX requests
     */
    public function getCities()
    {
        $cities = City::select('id', 'name')->orderBy('name')->get();
        return response()->json($cities);
    }

    /**
     * Get centers by city for AJAX requests
     */
    public function getCentersByCity(Request $request)
    {
        $cityId = $request->get('city_id');

        $centers = Center::where('city_id', $cityId)
                        ->select('id', 'name')
                        ->orderBy('name')
                        ->get();

        return response()->json($centers);
    }
}