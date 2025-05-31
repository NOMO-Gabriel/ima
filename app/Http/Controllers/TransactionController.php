<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionReason;
use App\Models\User;
use App\Models\Center;
use App\Models\Installment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['reason', 'receiver', 'center', 'creator']);

        // Filtres
        if ($request->filled('direction')) {
            $query->whereHas('reason', function ($q) use ($request) {
                $q->where('direction', $request->direction);
            });
        }

        if ($request->filled('reason_id')) {
            $query->where('reason_id', $request->reason_id);
        }

        if ($request->filled('center_id')) {
            $query->where('center_id', $request->center_id);
        }

        if ($request->filled('valid')) {
            $query->where('valid', $request->boolean('valid'));
        }

        // Recherche par description
        if ($request->filled('search')) {
            $query->where('description', 'LIKE', '%' . $request->search . '%');
        }

        // Tri par date décroissante
        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistiques
        $stats = [
            'total_in' => Transaction::whereHas('reason', function ($q) {
                $q->where('direction', 'IN');
            })->where('valid', true)->sum('amount'),

            'total_out' => Transaction::whereHas('reason', function ($q) {
                $q->where('direction', 'OUT');
            })->where('valid', true)->sum('amount'),
        ];

        $stats['balance'] = $stats['total_in'] - $stats['total_out'];

        // Données pour les filtres
        $reasons = TransactionReason::orderBy('direction')->orderBy('label')->get();
        $centers = Center::orderBy('name')->get();

        // Substract OUT transactions from OUT transactions
        $transactionsAmount = Transaction::whereHas('reason', function ($q) {
            $q->where('direction', 'IN');
        })->where('valid', true)->sum('amount');
        $transactionsAmount = $transactionsAmount - Transaction::whereHas('reason', function ($q) {
            $q->where('direction', 'OUT');
        })->where('valid', true)->sum('amount');
        
        $registrationsAmount = Installment::sum('amount');
        $balance = $registrationsAmount + $transactionsAmount;

        return view('admin.transactions.index', compact(
            'balance',
            'transactionsAmount',
            'registrationsAmount',
            'transactions',
            'reasons',
            'centers',
            'stats'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $reasons = TransactionReason::orderBy('direction')->orderBy('label')->get();
        $users = User::orderBy('first_name')->orderBy('last_name')->get();
        $centers = Center::orderBy('name')->get();

        return view('admin.transactions.create', compact('reasons', 'users', 'centers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reason_id' => 'required|exists:transaction_reasons,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'receiver_id' => 'nullable|exists:users,id',
            'center_id' => 'nullable|exists:centers,id',
        ]);

        $validated['created_by'] = Auth::id();

        $transaction = Transaction::create($validated);

        log_history('created', $transaction, ['before' => [], 'after' => $validated]);

        return redirect()->route('admin.transactions.index', app()->getLocale())
            ->with('success', 'Transaction créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['reason', 'receiver', 'center', 'creator']);

        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $reasons = TransactionReason::orderBy('direction')->orderBy('label')->get();
        $users = User::orderBy('first_name')->orderBy('last_name')->get();
        $centers = Center::orderBy('name')->get();

        return view('admin.transactions.edit', compact('transaction', 'reasons', 'users', 'centers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'reason_id' => 'required|exists:transaction_reasons,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'receiver_id' => 'nullable|exists:users,id',
            'center_id' => 'nullable|exists:centers,id',
        ]);

        $transaction->update($validated);

        log_history('updated', $transaction, ['before' => $transaction->getOriginal(), 'after' => $validated]);

        return redirect()->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaction mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        log_history('deleted', $transaction, ['before' => $transaction->toArray(), 'after' => []]);

        return redirect()->route('admin.transactions.index', app()->getLocale())
            ->with('success', 'Transaction supprimée avec succès.');
    }

    /**
     * Get transactions statistics for dashboard
     */
    public function stats()
    {
        $stats = [
            'total_transactions' => Transaction::count(),
            'valid_transactions' => Transaction::where('valid', true)->count(),
            'invalid_transactions' => Transaction::where('valid', false)->count(),

            'total_in' => Transaction::whereHas('reason', function ($q) {
                $q->where('direction', 'IN');
            })->where('valid', true)->sum('amount'),

            'total_out' => Transaction::whereHas('reason', function ($q) {
                $q->where('direction', 'OUT');
            })->where('valid', true)->sum('amount'),

            'recent_transactions' => Transaction::with(['reason', 'receiver', 'center'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),

            'top_reasons' => Transaction::select('reason_id', DB::raw('count(*) as count'))
                ->with('reason')
                ->groupBy('reason_id')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get(),
        ];

        $stats['balance'] = $stats['total_in'] - $stats['total_out'];

        return $stats;
    }

    /**
     * Export transactions to CSV
     */
    public function export(Request $request)
    {
        $query = Transaction::with(['reason', 'receiver', 'center', 'creator']);

        // Appliquer les mêmes filtres que l'index
        if ($request->filled('direction')) {
            $query->whereHas('reason', function ($q) use ($request) {
                $q->where('direction', $request->direction);
            });
        }

        if ($request->filled('reason_id')) {
            $query->where('reason_id', $request->reason_id);
        }

        if ($request->filled('center_id')) {
            $query->where('center_id', $request->center_id);
        }

        if ($request->filled('valid')) {
            $query->where('valid', $request->boolean('valid'));
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $filename = 'transactions_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Date',
                'Direction',
                'Raison',
                'Montant',
                'Description',
                'Bénéficiaire',
                'Centre',
                'Statut',
                'Créé par',
            ]);

            // Données
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->created_at->format('d/m/Y H:i'),
                    $transaction->reason->direction,
                    $transaction->reason->label,
                    $transaction->amount,
                    $transaction->description,
                    $transaction->receiver ? $transaction->receiver->first_name . ' ' . $transaction->receiver->last_name : '',
                    $transaction->center ? $transaction->center->name : '',
                    $transaction->valid ? 'Valide' : 'Invalide',
                    $transaction->creator ? $transaction->creator->first_name . ' ' . $transaction->creator->last_name : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
