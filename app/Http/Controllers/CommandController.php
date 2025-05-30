<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Material;
use App\Models\CommandUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource with advanced filtering and search
     */
    public function index(Request $request)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.read')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de voir les commandes.');
        }

        // Construction de la requête de base avec les relations
        $query = Command::with(['user', 'commandUnits.material']);

        // Filtrage par recherche
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filtrage par période
        if ($request->filled('period')) {
            $period = $request->get('period');

            switch ($period) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        // Tri des résultats
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // Validation des champs de tri autorisés
        $allowedSortFields = ['created_at', 'updated_at', 'quantity', 'user_id'];
        if (in_array($sortField, $allowedSortFields)) {
            if ($sortField === 'user_id') {
                // Tri par nom d'utilisateur
                $query->leftJoin('users', 'commands.user_id', '=', 'users.id')
                    ->orderBy('users.first_name', $sortDirection)
                    ->orderBy('users.last_name', $sortDirection)
                    ->select('commands.*');
            } else {
                $query->orderBy($sortField, $sortDirection);
            }
        } else {
            $query->latest();
        }

        // Pagination avec conservation des paramètres de recherche
        $commands = $query->paginate(15)->withQueryString();

        // Calcul des statistiques pour le dashboard
        $stats = $this->calculateStats();

        return view('admin.commands.index', compact('commands', 'stats'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.create')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de créer une commande.');
        }

        // Récupérer tous les matériels disponibles avec leurs quantités actuelles
        $materials = Material::orderBy('name')->get();

        return view('admin.commands.create', compact('materials'));
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.create')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de créer une commande.');
        }

        // Validation des données
        $validated = $request->validate([
            'units' => 'required|array|min:1',
            'units.*.material_id' => 'required|exists:materials,id',
            'units.*.quantity' => 'required|integer|min:1|max:10000',
            'notes' => 'nullable|string|max:1000',
        ], [
            'units.required' => 'Vous devez ajouter au moins un matériel à la commande.',
            'units.min' => 'Vous devez ajouter au moins un matériel à la commande.',
            'units.*.material_id.required' => 'Le matériel est obligatoire.',
            'units.*.material_id.exists' => 'Le matériel sélectionné n\'existe pas.',
            'units.*.quantity.required' => 'La quantité est obligatoire.',
            'units.*.quantity.min' => 'La quantité doit être d\'au moins 1.',
            'units.*.quantity.max' => 'La quantité ne peut pas dépasser 10 000.',
            'notes.max' => 'Les notes ne peuvent pas dépasser 1000 caractères.',
        ]);

        DB::beginTransaction();

        try {
            // Calcul de la quantité totale
            $totalQuantity = array_sum(array_column($validated['units'], 'quantity'));

            // Validation : vérifier que les matériels ne sont pas dupliqués
            $materialIds = array_column($validated['units'], 'material_id');
            if (count($materialIds) !== count(array_unique($materialIds))) {
                throw new \Exception('Vous ne pouvez pas ajouter le même matériel plusieurs fois.');
            }

            // Vérification de la disponibilité des matériels
            foreach ($validated['units'] as $unit) {
                $material = Material::find($unit['material_id']);
                if ($material && $material->quantity < $unit['quantity']) {
                    throw new \Exception("Stock insuffisant pour {$material->name}. Stock disponible: {$material->quantity}");
                }
            }

            // Création de la commande
            $command = Command::create([
                'quantity' => $totalQuantity,
                'user_id' => Auth::id(),
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending', // Statut initial
            ]);

            // Création des unités de commande
            foreach ($validated['units'] as $unit) {
                CommandUnit::create([
                    'command_id' => $command->id,
                    'material_id' => $unit['material_id'],
                    'quantity' => $unit['quantity'],
                ]);

                // Optionnel : Réduire le stock du matériel (si gestion automatique)
                // Material::where('id', $unit['material_id'])->decrement('quantity', $unit['quantity']);
            }

            DB::commit();

            if (function_exists('log_history')) {
                log_history(
                    'created',
                    $command,
                    ['new_data' => $command->toArray()],
                    'Académie créée'
                );
            }

            return redirect()
                ->route('admin.commands.index', ['locale' => app()->getLocale()])
                ->with('success', 'Commande créée avec succès. ID: #' . $command->id);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création de la commande: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource
     */
    public function show($locale, Command $command)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.read')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de voir cette commande.');
        }

        // Charger les relations nécessaires
        $command->load(['user', 'commandUnits.material']);

        return view('admin.commands.show', compact('command'));
    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit($locale, Command $command)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.update')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de modifier cette commande.');
        }

        // Vérifier si la commande peut être modifiée (ex: statut pending)
        if (isset($command->status) && $command->status === 'completed') {
            return back()->with('error', 'Cette commande ne peut plus être modifiée car elle est déjà terminée.');
        }

        // Charger les relations et les matériels disponibles
        $command->load(['commandUnits.material']);
        $materials = Material::orderBy('name')->get();

        return view('admin.commands.edit', compact('command', 'materials'));
    }

    /**
     * Update the specified resource in storage
     */
    public function update($locale, Request $request, Command $command)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.update')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de modifier cette commande.');
        }

        // Vérifier si la commande peut être modifiée
        if (isset($command->status) && $command->status === 'completed') {
            return back()->with('error', 'Cette commande ne peut plus être modifiée car elle est déjà terminée.');
        }

        // Validation des données
        $validated = $request->validate([
            'units' => 'required|array|min:1',
            'units.*.id' => 'nullable|exists:command_units,id',
            'units.*.material_id' => 'required|exists:materials,id',
            'units.*.quantity' => 'required|integer|min:1|max:10000',
            'notes' => 'nullable|string|max:1000',
            'status' => 'nullable|in:pending,processing,completed,cancelled',
        ], [
            'units.required' => 'Vous devez ajouter au moins un matériel à la commande.',
            'units.min' => 'Vous devez ajouter au moins un matériel à la commande.',
            'units.*.material_id.required' => 'Le matériel est obligatoire.',
            'units.*.material_id.exists' => 'Le matériel sélectionné n\'existe pas.',
            'units.*.quantity.required' => 'La quantité est obligatoire.',
            'units.*.quantity.min' => 'La quantité doit être d\'au moins 1.',
            'units.*.quantity.max' => 'La quantité ne peut pas dépasser 10 000.',
            'notes.max' => 'Les notes ne peuvent pas dépasser 1000 caractères.',
            'status.in' => 'Le statut sélectionné n\'est pas valide.',
        ]);

        DB::beginTransaction();

        try {
            // Calcul de la quantité totale
            $totalQuantity = array_sum(array_column($validated['units'], 'quantity'));

            // Validation : vérifier que les matériels ne sont pas dupliqués
            $materialIds = array_column($validated['units'], 'material_id');
            if (count($materialIds) !== count(array_unique($materialIds))) {
                throw new \Exception('Vous ne pouvez pas ajouter le même matériel plusieurs fois.');
            }

            // Mise à jour de la commande
            $command->update([
                'quantity' => $totalQuantity,
                'notes' => $validated['notes'] ?? null,
                'status' => $validated['status'] ?? $command->status,
                'updated_by' => Auth::id(),
            ]);

            // Suppression des anciennes unités de commande
            $command->commandUnits()->delete();

            // Création des nouvelles unités de commande
            foreach ($validated['units'] as $unit) {
                CommandUnit::create([
                    'command_id' => $command->id,
                    'material_id' => $unit['material_id'],
                    'quantity' => $unit['quantity'],
                ]);
            }

            DB::commit();

            // Si le statut passe à "completed", décrémenter la quantité de matériel
            if ($unit['status'] === 'completed') {
                Material::where('id', $unit['material_id'])
                    ->decrement('quantity', $unit['quantity']);
            }

            return redirect()
                ->route('admin.commands.index', ['locale' => app()->getLocale()])
                ->with('success', 'Commande mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour de la commande: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy($locale, Command $command)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.delete')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de supprimer cette commande.');
        }

        // Vérifier si la commande peut être supprimée
        if (isset($command->status) && in_array($command->status, ['processing', 'completed'])) {
            return back()->with('error', 'Cette commande ne peut pas être supprimée car elle est en cours de traitement ou terminée.');
        }

        DB::beginTransaction();

        try {
            // Sauvegarder les informations pour le log
            $commandId = $command->id;
            $commandQuantity = $command->quantity;

            // Supprimer les unités de commande (cascade automatique avec la relation)
            $command->commandUnits()->delete();

            // Optionnel : Restaurer le stock des matériels si nécessaire
            // foreach ($command->commandUnits as $unit) {
            //     Material::where('id', $unit->material_id)->increment('quantity', $unit->quantity);
            // }

            // Supprimer la commande
            $command->delete();

            DB::commit();

            if (function_exists('log_history')) {
                log_history(
                    'deleted',
                    $command,
                    ['deleted_data' => $commandId],
                    'Académie supprimée'
                );
            }

            return redirect()
                ->route('admin.commands.index', ['locale' => app()->getLocale()])
                ->with('success', "Commande #{$commandId} supprimée avec succès.");

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Erreur lors de la suppression de la commande: ' . $e->getMessage());
        }
    }

    /**
     * Duplicate a command
     */
    public function duplicate($locale, Command $command)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.create')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de dupliquer cette commande.');
        }

        DB::beginTransaction();

        try {
            // Créer une nouvelle commande basée sur l'existante
            $newCommand = Command::create([
                'quantity' => $command->quantity,
                'user_id' => Auth::id(),
                'notes' => $command->notes ? 'Copie de la commande #' . $command->id . ' - ' . $command->notes : 'Copie de la commande #' . $command->id,
                'status' => 'pending',
            ]);

            // Dupliquer les unités de commande
            foreach ($command->commandUnits as $unit) {
                CommandUnit::create([
                    'command_id' => $newCommand->id,
                    'material_id' => $unit->material_id,
                    'quantity' => $unit->quantity,
                ]);
            }

            DB::commit();

            // Log de l'activité
            activity()
                ->performedOn($newCommand)
                ->causedBy(Auth::user())
                ->log("Commande dupliquée depuis la commande #{$command->id}");

            return redirect()
                ->route('admin.commands.show', ['locale' => app()->getLocale(), 'command' => $newCommand->id])
                ->with('success', "Commande dupliquée avec succès. Nouvelle commande: #{$newCommand->id}");

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Erreur lors de la duplication de la commande: ' . $e->getMessage());
        }
    }

    /**
     * Export commands to CSV
     */
    public function export(Request $request)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.export')) {
            abort(403, 'Vous n\'avez pas l\'autorisation d\'exporter les commandes.');
        }

        // Récupérer les commandes avec les mêmes filtres que l'index
        $query = Command::with(['user', 'commandUnits.material']);

        // Appliquer les mêmes filtres que dans l'index
        if ($request->filled('search')) {
            // ... même logique de filtrage
        }

        $commands = $query->get();

        // Générer le CSV
        $filename = 'commandes_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($commands) {
            $file = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Date de création',
                'Quantité totale',
                'Utilisateur',
                'Email utilisateur',
                'Statut',
                'Notes'
            ]);

            // Données
            foreach ($commands as $command) {
                fputcsv($file, [
                    $command->id,
                    $command->created_at->format('d/m/Y H:i'),
                    $command->quantity,
                    $command->user->first_name . ' ' . $command->user->last_name,
                    $command->user->email,
                    $command->status ?? 'pending',
                    $command->notes ?? '',
                ]);
            }

            fclose($file);
        };

        // Log de l'activité
        activity()
            ->causedBy(Auth::user())
            ->log('Export de ' . $commands->count() . ' commandes en CSV');

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate statistics for the dashboard
     */
    private function calculateStats()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return [
            'total_commands' => Command::count(),
            'total_quantity' => Command::sum('quantity'),
            'commands_this_month' => Command::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),
            'pending_commands' => Command::where('status', 'pending')->count(),
            'completed_commands' => Command::where('status', 'completed')->count(),
            'last_command_date' => Command::latest()->first()?->created_at,
        ];
    }

    /**
     * Get materials for AJAX requests
     */
    public function getMaterials(Request $request)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.create') && !Auth::user()->can('ressource.material.update')) {
            abort(403, 'Accès non autorisé.');
        }

        $search = $request->get('search', '');

        $materials = Material::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name', 'unit', 'quantity']);

        return response()->json($materials);
    }

    /**
     * Update command status
     */
    public function updateStatus($locale, Command $command, Request $request)
    {
        // Vérifier les permissions
        if (!Auth::user()->can('ressource.material.update')) {
            abort(403, 'Vous n\'avez pas l\'autorisation de modifier le statut de cette commande.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $oldStatus = $command->status ?? 'pending';
        $command->update([
            'status' => $validated['status'],
            'updated_by' => Auth::id(),
        ]);

        // Log de l'activité
        activity()
            ->performedOn($command)
            ->causedBy(Auth::user())
            ->log("Statut de la commande changé de '{$oldStatus}' à '{$validated['status']}'");

        return back()->with('success', 'Statut de la commande mis à jour avec succès.');
    }
}
