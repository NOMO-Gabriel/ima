<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\MockExam;
use App\Models\Formation;
use Illuminate\Http\Request;

class MockExamController extends Controller
{
    public function index()
    {
        $mockExams = MockExam::with('formation')->get();
        return view('admin.mock-exams.index', compact('mockExams'));
    }

    public function show($locale, MockExam $mockExam)
    {
        return view('admin.mock-exams.show', compact('mockExam'));
    }

    public function create()
    {
        $formations = Formation::all();
        $courses = Course::all();

        return view('admin.mock-exams.create', compact('formations', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:QCM,REDACTION,MIX',
            'duration' => 'required|integer|min:0',

            'formation_id' => 'required|exists:formations,id',

            'course_ids' => 'array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $mockExam = MockExam::create($validated);

        if (!empty($validated['course_ids'])) {
            $mockExam->courses()->sync($validated['course_ids']);
        }

        return redirect()->route('admin.mock-exams.index', ['locale' => app()->getLocale()])
            ->with('success', 'Le concours blanc a été créé avec succès !');
    }

    public function edit($locale, MockExam $mockExam)
    {
        $formations = Formation::all();
        $courses = Course::all();

        return view('admin.mock-exams.edit', compact('mockExam', 'formations', 'courses'));
    }

    public function update($locale, Request $request, MockExam $mockExam)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:QCM,REDACTION,MIX',
            'duration' => 'required|integer|min:0',

            'formation_id' => 'required|exists:formations,id',

            'course_ids' => 'array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $mockExam->update($validated);

        if (isset($validated['course_ids'])) {
            $mockExam->courses()->sync($validated['course_ids']);
        }

        return redirect()->route('admin.mock-exams.index', ['locale' => app()->getLocale()])
            ->with('success', 'Concours blanc mis à jour avec succès.');
    }

    public function destroy($locale, MockExam $mockExam)
    {
        $mockExam->delete();

        return redirect()->route('admin.mock-exams.index', ['locale' => app()->getLocale()])
            ->with('success', 'Concours blanc supprimé avec succès.');
    }
}
