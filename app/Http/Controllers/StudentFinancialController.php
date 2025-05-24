<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EntranceExam;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentFinancialController extends Controller
{
    /**
     * Affiche la liste des élèves en attente de validation
     */
    public function pendingStudents()
    {
        // Vérifier que l'utilisateur est responsable financier
        if (!Auth::user()->hasRole(['resp-financier', 'df-ville', 'df-national'])) {
            abort(403, 'Accès refusé. Vous devez être responsable financier.');
        }

        $pendingStudents = User::where('account_type', 'eleve')
            ->where('status', User::STATUS_PENDING_VALIDATION)
            ->with(['city'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('finance.students.pending', compact('pendingStudents'));
    }

    /**
     * Affiche les élèves en attente d'assignation de contrat
     */
    public function pendingContract()
    {
        if (!Auth::user()->hasRole(['resp-financier', 'df-ville', 'df-national'])) {
            abort(403, 'Accès refusé. Vous devez être responsable financier.');
        }

        $pendingContract = User::where('account_type', 'eleve')
            ->where('status', User::STATUS_PENDING_CONTRACT)
            ->with(['city', 'financialValidator'])
            ->orderBy('financial_validation_date', 'desc')
            ->paginate(15);

        return view('finance.students.pending-contract', compact('pendingContract'));
    }

    /**
     * Valide un élève (première étape)
     */
    public function validateStudent(Request $request, User $student)
    {
        if (!Auth::user()->hasRole(['resp-financier', 'df-ville', 'df-national'])) {
            abort(403, 'Accès refusé');
        }

        if ($student->account_type !== 'eleve' || $student->status !== User::STATUS_PENDING_VALIDATION) {
            return back()->with('error', 'Cet élève ne peut pas être validé.');
        }

        $student->validateByFinancial(Auth::user());

        // TODO: Ajouter notification email plus tard
        // $student->notify(new StudentAccountValidated($student));

        return back()->with('success', 'Élève validé avec succès. Vous pouvez maintenant lui assigner ses concours et contrat.');
    }

    /**
     * Affiche le formulaire d'assignation de contrat et concours
     */
    public function showContractForm(User $student)
    {
        if (!Auth::user()->hasRole(['resp-financier', 'df-ville', 'df-national'])) {
            abort(403, 'Accès refusé');
        }

        if ($student->status !== User::STATUS_PENDING_CONTRACT) {
            return back()->with('error', 'Cet élève n\'est pas en attente d\'assignation de contrat.');
        }

        $entranceExams = EntranceExam::all();
        $formations = Formation::all();

        return view('finance.students.assign-contract', compact('student', 'entranceExams', 'formations'));
    }

    /**
     * Assigne le contrat et les concours à un élève
     */
    public function assignContract(Request $request, User $student)
    {
        if (!Auth::user()->hasRole(['resp-financier', 'df-ville', 'df-national'])) {
            abort(403, 'Accès refusé');
        }

        $request->validate([
            'entrance_exams' => 'required|array|min:1',
            'entrance_exams.*' => 'exists:entrance_exams,id',
            'formation_id' => 'required|exists:formations,id',
            'contract_amount' => 'required|numeric|min:0',
            'payment_schedule' => 'required|string|in:monthly,quarterly,semester,annual',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'special_conditions' => 'nullable|string|max:1000',
        ]);

        if ($student->status !== User::STATUS_PENDING_CONTRACT) {
            return back()->with('error', 'Cet élève n\'est pas en attente d\'assignation de contrat.');
        }

        // Récupérer les détails des concours sélectionnés
        $selectedExams = EntranceExam::whereIn('id', $request->entrance_exams)->get();
        $formation = Formation::find($request->formation_id);

        $entranceExams = $selectedExams->map(function ($exam) {
            return [
                'id' => $exam->id,
                'name' => $exam->name,
                'code' => $exam->code,
            ];
        })->toArray();

        $contractDetails = [
            'formation' => [
                'id' => $formation->id,
                'name' => $formation->name,
            ],
            'amount' => $request->contract_amount, // Montant à payer par l'élève
            'payment_schedule' => $request->payment_schedule, // Comment il va payer (mensuel, etc.)
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'special_conditions' => $request->special_conditions,
            'assigned_by' => Auth::user()->id,
            'assigned_by_name' => Auth::user()->full_name,
            'assigned_at' => now()->toISOString(),
        ];

        $student->assignContractAndExams($entranceExams, $contractDetails, Auth::user());

        // TODO: Ajouter les notifications email plus tard
        // $student->notify(new StudentAccountActivated($student));

        return redirect()->route('finance.students.pending-contract', ['locale' => app()->getLocale()])
            ->with('success', 'Contrat et concours assignés avec succès. Le compte de l\'élève est maintenant actif.');
    }

    /**
     * Rejette un élève
     */
    public function rejectStudent(Request $request, User $student)
    {
        if (!Auth::user()->hasRole(['resp-financier', 'df-ville', 'df-national'])) {
            abort(403, 'Accès refusé');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if (!in_array($student->status, [User::STATUS_PENDING_VALIDATION, User::STATUS_PENDING_CONTRACT])) {
            return back()->with('error', 'Cet élève ne peut pas être rejeté.');
        }

        $student->status = User::STATUS_REJECTED;
        $student->rejection_reason = $request->rejection_reason;
        $student->validated_by_financial = Auth::user()->id;
        $student->financial_validation_date = now();
        $student->save();

        // TODO: Ajouter notification email plus tard  
        // $student->notify(new StudentAccountRejected($student));

        return back()->with('success', 'Élève rejeté avec succès.');
    }

    /**
     * Affiche les détails d'un élève
     */
    public function showStudent(User $student)
    {
        if (!Auth::user()->hasRole(['resp-financier', 'df-ville', 'df-national'])) {
            abort(403, 'Accès refusé');
        }

        if ($student->account_type !== 'eleve') {
            abort(404, 'Élève non trouvé');
        }

        return view('finance.students.show', compact('student'));
    }
}