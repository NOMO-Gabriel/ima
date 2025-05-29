<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Installment;
use App\Models\PaymentMethod;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstallmentController extends Controller
{
    /**
     * Affiche la liste des versements pour une inscription
     */
    public function index(Request $request, $locale)
    {
        $registrationId = $request->get('registration');

        if (!$registrationId) {
            return redirect()->back()->with('error', 'Paramètres manquants');
        }

        // $student = Student::findOrFail($studentId);
        $registration = Registration::findOrFail($registrationId);
        $student = $registration->student;

        return view('admin.finance.students.installments.index', compact('student', 'registration'));
    }

    public function store(Request $request)
    {
        $studentId = $request->input('student_id') ?? $request->get('student');
        $student = Student::findOrFail($studentId);
        $registration = $student->registration;

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'notes' => 'nullable|string',
        ]);

        Installment::create([
            'amount' => $validated['amount'],
            'notes' => $validated['notes'] ?? null,
            'payment_method_id' => $validated['payment_method_id'],
            'registration_id' => $registration->id,
            'processed_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Versement ajouté avec succès.');
    }
}
