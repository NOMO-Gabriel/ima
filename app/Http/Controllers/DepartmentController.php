<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($this->user && !$this->user->can('department.view')) {
            abort(403, 'Non autorisé');
        }

        // Filtrage des départements
        $query = Department::query();

        // Filtrer par académie
        if ($request->filled('academy_id')) {
            $query->where('academy_id', $request->academy_id);
        }

        // Recherche par texte
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? true : false;
            $query->where('is_active', $status);
        }

        $departments = $query->with(['academy', 'head'])->latest()->paginate(10);
        $academies = Academy::where('is_active', true)->get();

        return view('admin.departments.index', compact('departments', 'academies'));
    }

    public function create()
    {
        if ($this->user && !$this->user->can('department.create')) {
            abort(403, 'Non autorisé');
        }

        $academies = Academy::where('is_active', true)->get();

        $heads = User::whereHas('roles', function($query) {
            $query->where('name', 'Chef-Departement');
        })->get();

        return view('admin.departments.create', compact('academies', 'heads'));
    }

    public function store($locale, Request $request)
    {
        if ($this->user && !$this->user->can('department.create')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:departments'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'academy_id' => ['required', 'exists:academies,id'],
            'head_id' => ['nullable', 'exists:users,id'],
        ]);

        Department::create($validated);

        return redirect()->route('admin.departments.index', ['locale' => app()->getLocale()])
            ->with('success', 'Département créé avec succès.');
    }

    public function edit($locale, Department $department)
    {
        if ($this->user && !$this->user->can('department.update')) {
            abort(403, 'Non autorisé');
        }

        // Récupérer les académies actives
        $academies = Academy::where('is_active', true)->get();

        // Récupérer les utilisateurs qui peuvent être chefs de département
        $heads = User::whereHas('roles', function($query) {
            $query->where('name', 'Chef-Departement');
        })->get();

        return view('admin.departments.edit', compact('department', 'academies', 'heads'));
    }

    public function update($locale, Request $request, Department $department)
    {
        if ($this->user && !$this->user->can('department.update')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:departments,code,' . $department->id],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'academy_id' => ['required', 'exists:academies,id'],
            'head_id' => ['nullable', 'exists:users,id'],
        ]);

        $department->update($validated);

        return redirect()->route('admin.departments.index', ['locale' => app()->getLocale()])
            ->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy($locale, Department $department)
    {
        if ($this->user && !$this->user->can('department.delete')) {
            abort(403, 'Non autorisé');
        }

        $department->delete();

        return redirect()->route('admin.departments.index', ['locale' => app()->getLocale()])
            ->with('success', 'Département supprimé avec succès.');
    }
}