<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord principal
     */
    public function dashboard()
    {
        // Récupération de statistiques pour le dashboard
        $stats = [
            'users_count' => User::count(),
            'teachers_count' => User::role('enseignant')->count(),
            'students_count' => User::role('eleve')->count(),
            'staff_count' => User::whereHas('roles', function($q) {
                $q->whereNotIn('name', ['enseignant', 'eleve', 'parent']);
            })->count(),
        ];
        
        // Derniers utilisateurs inscrits
        $latest_users = User::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'latest_users'));
    }
}