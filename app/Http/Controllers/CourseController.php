<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($this->user && !$this->user->can('course.view')) {
            abort(403, 'Non autorisé');
        }

        $courses = Course::latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if ($this->user && !$this->user->can('course.create')) {
            abort(403, 'Non autorisé');
        }

        $formations = Formation::all();

        return view('admin.courses.create', compact('formations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->user && !$this->user->can('course.create')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:courses,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'formations' => 'nullable|array',
            'formations.*' => 'exists:formations,id',
        ]);

        $course = Course::create([
            'code' => $validated['code'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        if (isset($validated['formations'])) {
            $course->formations()->sync($validated['formations']);
        }

        return redirect()->route('admin.courses.index', ['locale' => app()->getLocale()])
            ->with('success', 'Le cours a été créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Course $course)
    {
        if ($this->user && !$this->user->can('course.view')) {
            abort(403, 'Non autorisé');
        }

        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Course $course)
    {
        if ($this->user && !$this->user->can('course.update')) {
            abort(403, 'Non autorisé');
        }

        $formations = Formation::all();

        return view('admin.courses.edit', compact('course', 'formations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Course $course)
    {
        if ($this->user && !$this->user->can('course.update')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:courses,code,' . $course->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'formations' => 'nullable|array',
            'formations.*' => 'exists:formations,id',
        ]);

        $course->update($validated);

        if (isset($validated['formations'])) {
            $course->formations()->sync($validated['formations']);
        } else {
            $course->formations()->detach();
        }

        return redirect()->route('admin.courses.index', ['locale' => app()->getLocale()])
            ->with('success', 'Cours mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Course $course)
    {
        if ($this->user && !$this->user->can('course.delete')) {
            abort(403, 'Non autorisé');
        }

        $course->delete();

        return redirect()->route('admin.courses.index', ['locale' => app()->getLocale()])
            ->with('success', 'Cours supprimé avec succès.');
    }
}
