<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function index(Request $request)
    {
        $query = Material::with(['center.city']);

        // Filtre par centre
        if ($request->filled('center_id')) {
            $query->where('center_id', $request->center_id);
        }

        // Filtre par unité
        if ($request->filled('unit')) {
            $query->where('unit', $request->unit);
        }

        // Filtre par statut de stock
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'out_of_stock':
                    $query->where('quantity', '<=', 0);
                    break;
                case 'low_stock':
                    $query->where('quantity', '>', 0)->where('quantity', '<=', 10);
                    break;
                case 'in_stock':
                    $query->where('quantity', '>', 10);
                    break;
            }
        }

        // Recherche par texte
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Tri
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');

        $allowedSorts = ['name', 'quantity', 'unit', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('name', 'asc');
        }

        $materials = $query->paginate(15);

        // Données pour les filtres
        $centers = Center::where('is_active', true)
            ->with('city')
            ->orderBy('name')
            ->get();

        $units = $this->units;

        // Statistiques
        $stats = [
            'total' => Material::count(),
            'out_of_stock' => Material::where('quantity', '<=', 0)->count(),
            'low_stock' => Material::where('quantity', '>', 0)->where('quantity', '<=', 10)->count(),
            'in_stock' => Material::where('quantity', '>', 10)->count(),
        ];

        return view('admin.materials.index', compact('materials', 'centers', 'units', 'stats'));
    }

    public function create()
    {
        $units = $this->units;
        $centers = Center::where('is_active', true)
            ->with('city')
            ->orderBy('name')
            ->get();

        return view('admin.materials.create', compact('units', 'centers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:materials,name',
            'description' => 'nullable|string|max:1000',
            'unit' => 'required|in:pcs,kg,g,m,cm,mm,l,ml,m2,m3,set,box,pack',
            'quantity' => 'required|integer|min:0',
            'center_id' => 'required|exists:centers,id',
        ], [
            'name.required' => 'Le nom du matériel est obligatoire.',
            'name.unique' => 'Un matériel avec ce nom existe déjà.',
            'unit.required' => 'L\'unité de mesure est obligatoire.',
            'unit.in' => 'L\'unité de mesure sélectionnée n\'est pas valide.',
            'quantity.required' => 'La quantité est obligatoire.',
            'quantity.integer' => 'La quantité doit être un nombre entier.',
            'quantity.min' => 'La quantité ne peut pas être négative.',
            'center_id.required' => 'Le centre d\'affectation est obligatoire.',
            'center_id.exists' => 'Le centre sélectionné n\'existe pas.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
        ]);

        // Vérifier que le centre est actif
        $center = Center::where('id', $validated['center_id'])
            ->where('is_active', true)
            ->first();

        if (!$center) {
            return back()
                ->withInput()
                ->withErrors(['center_id' => 'Le centre sélectionné n\'est pas disponible.']);
        }

        $material = Material::create($validated);

        // Log de l'activité
        if (function_exists('log_history')) {
            log_history('created', $material, [], "Matériel '{$material->name}' ajouté au centre '{$center->name}'");
        }

        return redirect()
            ->route('admin.materials.index', ['locale' => app()->getLocale()])
            ->with('success', "Le matériel '{$material->name}' a été ajouté avec succès au centre '{$center->name}'.");
    }

    public function show($locale, Material $material)
    {
        $material->load(['center.city']);

        return view('admin.materials.show', compact('material'));
    }

    public function edit($locale, Material $material)
    {
        $units = $this->units;
        $centers = Center::where('is_active', true)
            ->with('city')
            ->orderBy('name')
            ->get();

        return view('admin.materials.edit', compact('material', 'units', 'centers'));
    }

    public function update($locale, Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:materials,name,' . $material->id,
            'description' => 'nullable|string|max:1000',
            'unit' => 'required|in:pcs,kg,g,m,cm,mm,l,ml,m2,m3,set,box,pack',
            'quantity' => 'required|integer|min:0',
            'center_id' => 'required|exists:centers,id',
        ], [
            'name.required' => 'Le nom du matériel est obligatoire.',
            'name.unique' => 'Un matériel avec ce nom existe déjà.',
            'unit.required' => 'L\'unité de mesure est obligatoire.',
            'unit.in' => 'L\'unité de mesure sélectionnée n\'est pas valide.',
            'quantity.required' => 'La quantité est obligatoire.',
            'quantity.integer' => 'La quantité doit être un nombre entier.',
            'quantity.min' => 'La quantité ne peut pas être négative.',
            'center_id.required' => 'Le centre d\'affectation est obligatoire.',
            'center_id.exists' => 'Le centre sélectionné n\'existe pas.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
        ]);

        // Vérifier que le centre est actif
        $center = Center::where('id', $validated['center_id'])
            ->where('is_active', true)
            ->first();

        if (!$center) {
            return back()
                ->withInput()
                ->withErrors(['center_id' => 'Le centre sélectionné n\'est pas disponible.']);
        }

        // Préparer les changements pour l'historique
        $changes = [
            'before' => $material->toArray(),
            'after' => array_merge($material->toArray(), $validated)
        ];

        $material->update($validated);

        // Log de l'activité
        if (function_exists('log_history')) {
            log_history('updated', $material, $changes, "Matériel '{$material->name}' modifié");
        }

        return redirect()
            ->route('admin.materials.index', ['locale' => app()->getLocale()])
            ->with('success', "Le matériel '{$material->name}' a été mis à jour avec succès.");
    }

    public function destroy($locale, Material $material)
    {
        // Vérifier s'il y a des commandes liées à ce matériel
        if ($material->commandUnits()->exists()) {
            return back()->with('error',
                'Impossible de supprimer ce matériel car il est utilisé dans des commandes.'
            );
        }

        $materialName = $material->name;
        $centerName = $material->center->name ?? 'Centre inconnu';

        // Log de l'activité avant suppression
        if (function_exists('log_history')) {
            log_history('deleted', $material, [], "Matériel '{$materialName}' supprimé du centre '{$centerName}'");
        }

        $material->delete();

        return redirect()
            ->route('admin.materials.index', ['locale' => app()->getLocale()])
            ->with('success', "Le matériel '{$materialName}' a été supprimé avec succès.");
    }

    /**
     * Ajuster la quantité d'un matériel (entrée/sortie de stock)
     */
    public function adjustStock($locale, Request $request, Material $material)
    {
        $validated = $request->validate([
            'adjustment_type' => 'required|in:add,subtract',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
        ]);

        $oldQuantity = $material->quantity;

        if ($validated['adjustment_type'] === 'add') {
            $newQuantity = $oldQuantity + $validated['quantity'];
        } else {
            $newQuantity = max(0, $oldQuantity - $validated['quantity']);
        }

        $material->update(['quantity' => $newQuantity]);

        // Log de l'activité
        if (function_exists('log_history')) {
            $action = $validated['adjustment_type'] === 'add' ? 'Ajout' : 'Retrait';
            $description = "{$action} de {$validated['quantity']} {$material->unit} - ";
            $description .= "Stock: {$oldQuantity} → {$newQuantity}";
            if ($validated['reason']) {
                $description .= " - Raison: {$validated['reason']}";
            }

            log_history('stock_adjusted', $material, [
                'before' => ['quantity' => $oldQuantity],
                'after' => ['quantity' => $newQuantity],
                'adjustment_type' => $validated['adjustment_type'],
                'adjustment_quantity' => $validated['quantity'],
                'reason' => $validated['reason']
            ], $description);
        }

        $message = $validated['adjustment_type'] === 'add'
            ? "Stock ajusté: +{$validated['quantity']} {$material->unit} ajouté(s)"
            : "Stock ajusté: -{$validated['quantity']} {$material->unit} retiré(s)";

        return back()->with('success', $message);
    }

    /**
     * Obtenir les matériels d'un centre spécifique (pour AJAX)
     */
    public function getByCenter($locale, Center $center)
    {
        $materials = $center->materials()
            ->select('id', 'name', 'quantity', 'unit')
            ->orderBy('name')
            ->get();

        return response()->json($materials);
    }

    /**
     * Recherche de matériels (pour autocomplete)
     */
    public function search(Request $request)
    {
        $term = $request->get('term', '');

        $materials = Material::where('name', 'like', "%{$term}%")
            ->with(['center:id,name'])
            ->select('id', 'name', 'quantity', 'unit', 'center_id')
            ->limit(10)
            ->get();

        return response()->json($materials->map(function ($material) {
            return [
                'id' => $material->id,
                'name' => $material->name,
                'quantity' => $material->quantity,
                'unit' => $material->unit,
                'center' => $material->center->name ?? 'Centre non défini',
                'label' => "{$material->name} ({$material->quantity} {$material->unit}) - {$material->center->name}",
                'value' => $material->name
            ];
        }));
    }

    /**
     * Export des matériels en CSV
     */
    public function export(Request $request)
    {
        $query = Material::with(['center.city']);

        // Appliquer les mêmes filtres que dans l'index
        if ($request->filled('center_id')) {
            $query->where('center_id', $request->center_id);
        }

        if ($request->filled('unit')) {
            $query->where('unit', $request->unit);
        }

        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'out_of_stock':
                    $query->where('quantity', '<=', 0);
                    break;
                case 'low_stock':
                    $query->where('quantity', '>', 0)->where('quantity', '<=', 10);
                    break;
                case 'in_stock':
                    $query->where('quantity', '>', 10);
                    break;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $materials = $query->orderBy('name')->get();

        $filename = 'materiels_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($materials) {
            $file = fopen('php://output', 'w');

            // BOM pour UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            // En-têtes CSV
            fputcsv($file, [
                'Nom',
                'Description',
                'Quantité',
                'Unité',
                'Centre',
                'Ville',
                'Statut',
                'Date de création',
                'Dernière modification'
            ], ';');

            // Données
            foreach ($materials as $material) {
                $status = 'En stock';
                if ($material->quantity <= 0) {
                    $status = 'Rupture';
                } elseif ($material->quantity <= 10) {
                    $status = 'Stock faible';
                }

                fputcsv($file, [
                    $material->name,
                    $material->description ?: 'Aucune description',
                    $material->quantity,
                    $this->units[$material->unit] ?? $material->unit,
                    $material->center->name ?? 'Centre non défini',
                    $material->center->city->name ?? 'Ville non définie',
                    $status,
                    $material->created_at->format('d/m/Y H:i'),
                    $material->updated_at->format('d/m/Y H:i')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Rapport de stock détaillé
     */
    public function stockReport(Request $request)
    {
        $centers = Center::where('is_active', true)
            ->with(['materials' => function($query) {
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        $totalMaterials = Material::count();
        $totalValue = 0; // Si vous avez un champ prix
        $alertsCount = Material::where('quantity', '<=', 10)->count();

        $stockAlerts = Material::where('quantity', '<=', 10)
            ->with(['center'])
            ->orderBy('quantity')
            ->get();

        return view('admin.materials.stock-report', compact(
            'centers',
            'totalMaterials',
            'totalValue',
            'alertsCount',
            'stockAlerts'
        ));
    }
}
