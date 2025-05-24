<?php

namespace App\Http\Controllers;

use App\Models\EntranceExam;
use Illuminate\Http\Request;

class EntranceExamController extends Controller
{
    public function index()
    {
        // if ($this->user && !$this->user->can('course.view')) {
        //     abort(403, 'Non autorisé');
        // }

        $entrance_exams = EntranceExam::all();
        return view('admin.entrance-exams.index', compact('entrance_exams'));
    }

    public function create()
    {
        // if ($this->user && !$this->user->can('course.create')) {
        //     abort(403, 'Non autorisé');
        // }

        return view('admin.entrance-exams.create');
    }

    public function store(Request $request)
    {
        if ($this->user && !$this->user->can('course.create')) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:entrance_exams,code',
            'name' => 'required|string|max:255',
        ]);

        EntranceExam::create($validated);

        return redirect()->route('admin.entrance-exams.index', ['locale' => app()->getLocale()])
            ->with('success', 'Le concours a été créé avec succès !');
    }

    public function edit($locale, EntranceExam $entrance_exam)
    {
        // if ($this->user && !$this->user->can('course.update')) {
        //     abort(403, 'Non autorisé');
        // }

        return view('admin.entrance-exams.edit', compact('entrance_exam'));
    }


    public function update($locale, Request $request, EntranceExam $entrance_exam)
    {
        // if ($this->user && !$this->user->can('course.update')) {
        //     abort(403, 'Non autorisé');
        // }

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:entrance_exams,code,' . $entrance_exam->id,
            'name' => 'required|string|max:255',
        ]);

        $entrance_exam->update($validated);

        return redirect()->route('admin.entrance-exams.index', ['locale' => app()->getLocale()])
            ->with('success', 'Concours mis à jour avec succès.');
    }

    public function destroy($locale, EntranceExam $entrance_exam)
    {
        // if ($this->user && !$this->user->can('course.delete')) {
        //     abort(403, 'Non autorisé');
        // }

        $entrance_exam->delete();

        return redirect()->route('admin.entrance-exams.index', ['locale' => app()->getLocale()])
            ->with('success', 'Concours supprimé avec succès.');
    }
}
