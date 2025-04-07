<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Academy;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Affiche la liste des départements
     */
    public function index()
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.view')) {
            abort(403, 'Non autorisé');
        }

        // Récupération des départements avec pagination
        $departments = Department::with('academy', 'head')->latest()->paginate(10);
        
        return view('departments.index', compact('departments'));
    }

    /**
     * Affiche le formulaire de création d'un département
     */
    public function create()
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.create')) {
            abort(403, 'Non autorisé');
        }
        
        // Récupération des académies
        $academies = Academy::all();
        
        // Récupération des utilisateurs qui peuvent être chefs de département
        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'Chef-Departement');
        })->get();
        
        return view('departments.create', compact('academies', 'users'));
    }

    /**
     * Enregistre un nouveau département
     */
    public function store(Request $request)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.create')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'academy_id' => ['required', 'exists:academies,id'],
            'head_id' => ['nullable', 'exists:users,id'],
        ]);
        
        // Vérifier l'unicité du nom dans l'académie
        $exists = Department::where('name', $request->name)
            ->where('academy_id', $request->academy_id)
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['name' => 'Un département avec ce nom existe déjà dans cette académie.'])
                ->withInput();
        }
        
        // Création du département
        $department = Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'academy_id' => $request->academy_id,
            'head_id' => $request->head_id,
            'created_by' => auth()->id(),
        ]);
        
        return redirect()->route('departments.index')
            ->with('success', 'Département créé avec succès.');
    }

    /**
     * Affiche les détails d'un département
     */
    public function show(Department $department)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.view')) {
            abort(403, 'Non autorisé');
        }
        
        // Récupération des formations associées à ce département
        $formations = $department->formations()->paginate(10);
        
        // Récupération des enseignants associés à ce département
        $teachers = $department->teachers()->paginate(10);
        
        return view('departments.show', compact('department', 'formations', 'teachers'));
    }

    /**
     * Affiche le formulaire de modification d'un département
     */
    public function edit(Department $department)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.update')) {
            abort(403, 'Non autorisé');
        }
        
        // Récupération des académies
        $academies = Academy::all();
        
        // Récupération des utilisateurs qui peuvent être chefs de département
        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'Chef-Departement');
        })->get();
        
        return view('departments.edit', compact('department', 'academies', 'users'));
    }

    /**
     * Met à jour un département
     */
    public function update(Request $request, Department $department)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.update')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'academy_id' => ['required', 'exists:academies,id'],
            'head_id' => ['nullable', 'exists:users,id'],
        ]);
        
        // Vérifier l'unicité du nom dans l'académie (sauf pour le département actuel)
        $exists = Department::where('name', $request->name)
            ->where('academy_id', $request->academy_id)
            ->where('id', '!=', $department->id)
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['name' => 'Un département avec ce nom existe déjà dans cette académie.'])
                ->withInput();
        }
        
        // Mise à jour du département
        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'academy_id' => $request->academy_id,
            'head_id' => $request->head_id,
            'updated_by' => auth()->id(),
        ]);
        
        return redirect()->route('departments.index')
            ->with('success', 'Département mis à jour avec succès.');
    }

    /**
     * Supprime un département
     */
    public function destroy(Department $department)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('department.delete')) {
            abort(403, 'Non autorisé');
        }
        
        // Vérifier si le département a des formations
        if ($department->formations()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce département car il contient des formations.');
        }
        
        // Vérifier si le département a des enseignants assignés
        if ($department->teachers()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce département car il a des enseignants assignés.');
        }
        
        // Suppression du département
        $department->delete();
        
        return redirect()->route('departments.index')
            ->with('success', 'Département supprimé avec succès.');
    }

    /**
     * Affiche le formulaire pour assigner des enseignants à un département
     */
    public function assignTeachersForm(Department $department)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('teacher.assign')) {
            abort(403, 'Non autorisé');
        }
        
        // Récupération des enseignants non assignés à ce département
        $available_teachers = User::role('Enseignant')
            ->whereDoesntHave('departments', function($query) use ($department) {
                $query->where('department_id', $department->id);
            })->get();
        
        return view('departments.assign_teachers', compact('department', 'available_teachers'));
    }

    /**
     * Assigne des enseignants à un département
     */
    public function assignTeachers(Request $request, Department $department)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('teacher.assign')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $request->validate([
            'teachers' => ['required', 'array'],
            'teachers.*' => ['exists:users,id'],
        ]);
        
        // Assignation des enseignants au département
        $department->teachers()->attach($request->teachers);
        
        return redirect()->route('departments.show', $department)
            ->with('success', 'Enseignants assignés avec succès au département.');
    }

    /**
     * Retire un enseignant d'un département
     */
    public function removeTeacher(Request $request, Department $department, User $user)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('teacher.assign')) {
            abort(403, 'Non autorisé');
        }
        
        // Retirer l'enseignant du département
        $department->teachers()->detach($user->id);
        
        return redirect()->route('departments.show', $department)
            ->with('success', 'Enseignant retiré avec succès du département.');
    }
}