<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Student;
use App\Models\Formation;
use App\Models\Installment;
use App\Models\Center;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {


        $registrations = Registration::with('student', 'formation', 'installments')->latest()->paginate(10);
        return view('admin.registrations.index', compact('registrations'));
    }

    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        $formations = Formation::orderBy('title')->get();
        $centers = Center::orderBy('name')->get();
        $paymentMethods = PaymentMethod::orderBy('label')->get();

        return view('admin.registrations.create', compact('students', 'formations', 'centers', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receipt_number' => 'required|string|unique:registrations,receipt_number',
            'contract' => 'required|numeric|min:0',
            'student_id' => 'required|exists:students,id',
            'formation_id' => 'required|exists:formations,id',
            'center_id' => 'required|exists:centers,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'first_installment' => 'nullable|numeric|min:0',
        ]);

        $registration = Registration::create([
            'receipt_number' => $validated['receipt_number'],
            'contract' => $validated['contract'],
            'student_id' => $validated['student_id'],
            'formation_id' => $validated['formation_id'],
            'center_id' => $validated['center_id'],
            'payment_method_id' => $validated['payment_method_id'] ?? null,
        ]);

        if (!empty($validated['first_installment']) && $validated['first_installment'] > 0) {
            Installment::create([
                'amount' => $validated['first_installment'],
                'registration_id' => $registration->id,
            ]);
        }

        return redirect()->route('admin.registrations.index', ['locale' => app()->getLocale()])
            ->with('success', 'Inscription créée avec succès.');
    }

    public function show($locale, Registration $registration)
    {


        $registration->load('student', 'formation', 'installments');
        return view('admin.registrations.show', compact('registration'));
    }

    public function edit($locale, Registration $registration)
    {


        $students = Student::orderBy('last_name')->get();
        $formations = Formation::orderBy('title')->get();
        $centers = Center::orderBy('name')->get();
        $paymentMethods = PaymentMethod::orderBy('label')->get();

        return view('admin.registrations.edit', compact('registration', 'students', 'formations', 'centers', 'paymentMethods'));
    }

    public function update($locale, Request $request, Registration $registration)
    {


        $validated = $request->validate([
            'receipt_number' => 'required|string|unique:registrations,receipt_number,' . $registration->id,
            'contract' => 'required|numeric|min:0',
            'student_id' => 'required|exists:students,id',
            'formation_id' => 'required|exists:formations,id',
            'center_id' => 'required|exists:centers,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
        ]);

        $registration->update($validated);

        return redirect()->route('admin.registrations.index', ['locale' => app()->getLocale()])
            ->with('success', 'Inscription mise à jour avec succès.');
    }

    public function destroy($locale, Registration $registration)
    {


        $registration->delete();

        return redirect()->route('admin.registrations.index', ['locale' => app()->getLocale()])
            ->with('success', 'Inscription supprimée avec succès.');
    }
}
