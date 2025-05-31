<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    /**
     * Display a listing of the materials.
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'booklet'); // Par défaut sur 'booklet'
        $search = $request->get('search');
        $sort = $request->get('sort', 'name-asc');

        $query = Material::query();

        // Filtrage par type
        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }

        // Recherche
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Tri
        switch ($sort) {
            case 'name-desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'stock-asc':
                $query->orderBy('stock', 'asc');
                break;
            case 'stock-desc':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $materials = $query->paginate(15);

        // Types disponibles pour les filtres
        $types = ['booklet', 'mock_exam', 'sheet', 'other'];

        // Statistiques
        $stats = [
            'total_materials' => Material::count(),
            'total_stock' => Material::sum('stock'),
            'total_value' => Material::select(DB::raw('SUM(stock * price) as total'))->value('total') ?? 0,
            'types_count' => Material::select('type')->distinct()->count(),
            'low_stock_count' => Material::where('stock', '<=', 5)->count(),
        ];

        return view('admin.materials.index', compact('materials', 'types', 'type', 'search', 'sort', 'stats'));
    }

    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|in:pcs,kg,g,m,cm,mm,l,ml,m2,m3,set,box,pack',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'type' => 'required|in:booklet,mock_exam,sheet,other',
        ]);

        $validated['user_id'] = Auth::id();

        Material::create($validated);

        return redirect()
            ->route('admin.materials.index', ['locale' => app()->getLocale(), 'type' => $validated['type']])
            ->with('success', 'Matériel créé avec succès !');
    }

    /**
     * Display the specified material and its commands.
     */
    public function show($locale, Request $request, Material $material)
    {
        $direction = $request->get('direction', 'all');
        $sort = $request->get('sort', 'recent');

        $query = Command::where('material_id', $material->id)
                        ->with(['user', 'city', 'center']);

        // Filtrage par direction
        if ($direction && $direction !== 'all') {
            $query->where('direction', $direction);
        }

        // Tri
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'quantity-asc':
                $query->orderBy('quantity', 'asc');
                break;
            case 'quantity-desc':
                $query->orderBy('quantity', 'desc');
                break;
            default: // recent
                $query->orderBy('created_at', 'desc');
        }

        $commands = $query->paginate(10);

        // Statistiques des commandes
        $commandStats = [
            'total_commands' => Command::where('material_id', $material->id)->count(),
            'total_in' => Command::where('material_id', $material->id)->where('direction', 'in')->sum('quantity'),
            'total_out' => Command::where('material_id', $material->id)->where('direction', 'out')->sum('quantity'),
            'recent_commands' => Command::where('material_id', $material->id)
                                      ->where('created_at', '>=', now()->subDays(7))
                                      ->count(),
        ];

        return view('admin.materials.show', compact('material', 'commands', 'direction', 'sort', 'commandStats'));
    }

    /**
     * Show the form for editing the specified material.
     */
    public function edit($locale, Material $material)
    {
        return response()->json($material);
    }

    /**
     * Update the specified material in storage.
     */
    public function update($locale, Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|in:pcs,kg,g,m,cm,mm,l,ml,m2,m3,set,box,pack',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'type' => 'required|in:booklet,mock_exam,sheet,other',
        ]);

        $material->update($validated);

        return redirect()
            ->route('admin.materials.index', ['locale' => app()->getLocale(), 'type' => $material->type])
            ->with('success', 'Matériel mis à jour avec succès !');
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy($locale, Material $material)
    {
        $type = $material->type;
        $material->delete();

        return redirect()
            ->route('admin.materials.index', ['locale' => app()->getLocale(), 'type' => $type])
            ->with('success', 'Matériel supprimé avec succès !');
    }
}