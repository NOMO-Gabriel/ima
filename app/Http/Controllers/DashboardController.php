<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer des statistiques pour le dashboard
        $stats = [
            'users_count' => User::count(),
            'teachers_count' => User::role('enseignant')->count(),
            'students_count' => User::role('eleve')->count(),
            'roles_count' => Role::count(),
        ];
        
        // Récupérer les dernières activités (utilisateurs récemment créés)
        $recent_users = User::latest()->take(5)->get();
        
        // Récupérer les rôles pour les statistiques
        $roles = Role::withCount('users')->orderBy('users_count', 'desc')->get();
        
        return view('dashboard', compact('stats', 'recent_users', 'roles'));
    }
}