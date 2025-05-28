<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        return Exam::all();
    }

    public function show($id)
    {
        return Exam::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:QCM,REDACTION,MIX',
            'duration' => 'integer|min:0',
            'formation_id' => 'required|exists:formations,id',
        ]);

        $exam = Exam::create($data);
        return response()->json($exam, 201);
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $data = $request->validate([
            'date' => 'sometimes|date',
            'type' => 'sometimes|in:QCM,REDACTION,MIX',
            'duration' => 'sometimes|integer|min:0',
            'formation_id' => 'sometimes|exists:formations,id',
        ]);

        $exam->update($data);
        return response()->json($exam);
    }

    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();
        return response()->noContent();
    }
}
