<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = History::with('user')->latest();

        // Filtres optionnels
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->subject_type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $histories = $query->paginate(50)->appends($request->query());

        // Pour les filtres
        $actions = History::distinct()->pluck('action')->filter();
        $subjectTypes = History::distinct()->pluck('subject_type')->filter();

        return view('admin.history.index', compact('histories', 'actions', 'subjectTypes'));
    }

    public function show($locale, History $history)
    {
        $history->load('user');
        return view('admin.history.show', compact('history'));
    }

    /**
     * Retourne le nom lisible du modèle
     */
    private function getModelName($subjectType)
    {
        $className = class_basename($subjectType);
        return ucfirst($className);
    }

    /**
     * Retourne la couleur selon l'action
     */
    private function getActionColor($action)
    {
        return match($action) {
            'created' => 'success',
            'updated' => 'primary',
            'deleted' => 'danger',
            'validated' => 'success',
            'suspended' => 'warning',
            'rejected' => 'danger',
            'archived' => 'secondary',
            default => 'secondary'
        };
    }
}