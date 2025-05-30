<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use App\Models\Center;
// Student est déjà là via User->student
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:student.view_any')->only('index');
        // $this->middleware('can:student.view')->only('show');
    }

    public function index(Request $request)
    {
        $query = User::query()
            ->where('account_type', 'student')
            ->whereHas('student');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender); // Fonctionnera si 'gender' est dans User::$fillable
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id); // Fonctionnera si 'city_id' est sur User
        }

        if ($request->filled('center_id')) {
            // Accède à $user->student->enrollments (qui est HasMany<Registration>)
            // Puis vérifie si l'une de ces Registration a le center_id
            $query->whereHas('student.enrollments', function ($q_enrollments) use ($request) {
                $q_enrollments->where('center_id', $request->center_id);
            });
        }

        if ($request->filled('sort') && $request->filled('direction')) {
            $sortField = $request->sort;
            $sortDirection = $request->direction === 'desc' ? 'desc' : 'asc';
            $allowedSortFields = ['first_name', 'email', 'status', 'created_at'];
            if (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortDirection);
                if ($sortField === 'first_name') $query->orderBy('last_name', $sortDirection);
            }
        } else {
            $query->latest('users.created_at');
        }

        $studentUsers = $query->with([
                                'student', // Profil Student
                                'student.enrollments.center', // Inscriptions (Registration) avec leur Centre
                                'student.enrollments.formation', // Inscription (Registration) avec sa Formation principale (BelongsTo)
                                'city' // Relation city() sur User
                               ])
                               ->paginate(15)
                               ->appends($request->query());

        // Données pour les filtres
        // Utiliser l'accessor du modèle User pour les labels de statut
        $statuses = collect([
            User::STATUS_PENDING_VALIDATION, User::STATUS_PENDING_CONTRACT, User::STATUS_ACTIVE,
            User::STATUS_SUSPENDED, User::STATUS_REJECTED, User::STATUS_ARCHIVED
        ])->mapWithKeys(function ($status) {
            // Crée une instance temporaire pour utiliser l'accessor, ou définissez une méthode statique dans User
            $tempUser = new User(['status' => $status]);
            return [$status => $tempUser->status_label];
        })->sort();


        $genders = User::getGenders(); // Depuis User model
        $citiesForFilter = City::where('is_active', true)->orderBy('name')->pluck('name', 'id');
        $centersForFilter = Center::where('is_active', true)->orderBy('name')->pluck('name', 'id');

        $statsQueryBase = User::where('account_type', 'student')->whereHas('student');
        $stats = [
            'total' => (clone $statsQueryBase)->count(),
            'active' => (clone $statsQueryBase)->where('status', User::STATUS_ACTIVE)->count(),
            'pending_validation' => (clone $statsQueryBase)->where('status', User::STATUS_PENDING_VALIDATION)->count(),
        ];

        return view('admin.students.index', compact(
            'studentUsers', 'statuses', 'genders', 'citiesForFilter', 'centersForFilter', 'stats'
        ));
    }

    public function show($locale, User $studentUser)
    {
        if ($studentUser->account_type !== 'student' || !$studentUser->student) {
            abort(404, "Profil étudiant non trouvé.");
        }

        $studentUser->load([
            'student', // Profil
            'student.enrollments' => function ($query) { // Inscriptions (Registration)
                $query->with(['center', 'formation']) // Centre et Formation principale (BelongsTo)
                      ->orderBy('created_at', 'desc');
            },
            'city', // Ville de l'utilisateur
            'validator',
            'finalizer',
        ]);

        return view('admin.students.show', compact('studentUser'));
    }
}