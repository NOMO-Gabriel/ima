<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Formation;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {

        $courses = Course::latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {

        $formations = Formation::all();

        return view('admin.courses.create', compact('formations'));
    }

    public function store(Request $request)
    {

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

    public function show($locale, Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    public function edit($locale, Course $course)
    {

        $formations = Formation::all();

        return view('admin.courses.edit', compact('course', 'formations'));
    }

    public function update($locale, Request $request, Course $course)
    {

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

    public function destroy($locale, Course $course)
    {

        $course->delete();

        return redirect()->route('admin.courses.index', ['locale' => app()->getLocale()])
            ->with('success', 'Cours supprimé avec succès.');
    }
}
