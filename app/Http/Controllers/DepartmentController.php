<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Academy;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with(['academy', 'head'])->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $academies = Academy::all();
        $users = User::all();
        return view('admin.departments.create', compact('academies', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:departments',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'academy_id' => 'nullable|exists:academies,id',
            'head_id' => 'nullable|exists:users,id',
        ]);

        Department::create($data);

        return redirect()->route('admin.departments.index', app()->getLocale())
            ->with('success', 'Département créé avec succès.');
    }

    public function show($locale, Department $department)
    {
        return view('admin.departments.show', compact('department'));
    }

    public function edit($locale, Department $department)
    {
        $academies = Academy::all();
        $users = User::all();
        return view('admin.departments.edit', compact('department', 'academies', 'users'));
    }

    public function update($locale, Request $request, Department $department)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'academy_id' => 'nullable|exists:academies,id',
            'head_id' => 'nullable|exists:users,id',
        ]);

        $department->update($data);

        return redirect()->route('admin.departments.index', app()->getLocale())
            ->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy($locale, Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index', app()->getLocale())
            ->with('success', 'Département supprimé avec succès.');
    }
}
