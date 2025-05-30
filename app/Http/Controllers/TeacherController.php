<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Academy;
use App\Models\Department;
use App\Models\Center;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:teacher.view_any')->only('index');
        // $this->middleware('can:teacher.view')->only('show');
        // $this->middleware('can:teacher.create')->only(['create', 'store']);
        // $this->middleware('can:teacher.update')->only(['edit', 'update']);
        // $this->middleware('can:teacher.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $query = User::query()
            ->where('account_type', 'teacher')
            ->whereHas('teacherProfile');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhereHas('teacherProfile', function ($subQ) use ($search) {
                      $subQ->where('matricule', 'like', "%{$search}%")
                           ->orWhere('cni', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        if ($request->filled('city_id')) { // Filtre sur la ville du profil enseignant
            $query->whereHas('teacherProfile', function ($q_profile) use ($request) {
                $q_profile->where('city_id', $request->input('city_id'));
            });
        }

        if ($request->filled('academy_id')) {
            $query->whereHas('teacherProfile', function ($q) use ($request) {
                $q->where('academy_id', $request->input('academy_id'));
            });
        }

        if ($request->filled('department_id')) {
            $query->whereHas('teacherProfile', function ($q) use ($request) {
                $q->where('department_id', $request->input('department_id'));
            });
        }

        if ($request->filled('matricule_filter')) {
            $query->whereHas('teacherProfile', function ($q) use ($request) {
                $q->where('matricule', 'like', '%' . $request->input('matricule_filter') . '%');
            });
        }

        $sortField = $request->input('sort', 'users.created_at');
        $sortDirection = $request->input('direction', 'desc');
        $allowedSortFields = ['first_name', 'email', 'status', 'users.created_at'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
             if ($sortField === 'first_name') {
                $query->orderBy('last_name', $sortDirection);
            }
        } else {
            $query->orderBy('users.created_at', 'desc');
        }

        $teacherUsers = $query->with([
                                'roles',
                                'teacherProfile.academy',
                                'teacherProfile.department',
                                'teacherProfile.center',
                                'teacherProfile.city' // Chargement de la ville via TeacherProfile
                               ])
                               ->paginate(15)
                               ->appends($request->query());

        $statuses = User::getStatuses();
        $genders = User::getGenders();
        $cities = City::where('is_active', true)->orderBy('name')->pluck('name', 'id');
        $academies = Academy::orderBy('name')->pluck('name', 'id');
        $departments = Department::where('is_active', true)->orderBy('name')->pluck('name', 'id');
        // dd($teacherUsers ->toArray());

        $stats = [
            'total' => User::where('account_type', 'teacher')->whereHas('teacherProfile')->count(),
            'active' => User::where('account_type', 'teacher')->whereHas('teacherProfile')->where('status', User::STATUS_ACTIVE)->count(),
        ];

        return view('admin.teachers.index', compact(
            'teacherUsers', 'statuses', 'genders', 'cities', 'academies', 'departments', 'stats'
        ));
    }

    public function create()
    {
        $academies = Academy::orderBy('name')->pluck('name', 'id');
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $centers = Center::orderBy('name')->pluck('name', 'id');
        $cities = City::where('is_active', true)->orderBy('name')->pluck('name', 'id');
        $genders = User::getGenders();
        $statuses = User::getStatuses(); // Ajouté pour être cohérent avec _form

        return view('admin.teachers.create', compact('academies', 'departments', 'centers', 'cities', 'genders', 'statuses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // User fields
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'], // Changé en nullable pour correspondre au formulaire
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone_number')], // Modifié
            'gender' => ['required', Rule::in(array_keys(User::getGenders()))],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],

            // Teacher profile fields
            'matricule' => ['nullable', 'string', 'max:255', Rule::unique('teachers', 'matricule')], // Modifié
            'salary' => ['nullable', 'numeric', 'min:0'],
            'cni' => ['nullable', 'string', 'max:255', Rule::unique('teachers', 'cni')], // Modifié
            'birthdate' => ['nullable', 'date', 'before_or_equal:today'],
            'birthplace' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'academy_id' => ['nullable', 'exists:academies,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'center_id' => ['nullable', 'exists:centers,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
                'gender' => $validatedData['gender'],
                'address' => $validatedData['address'], // Pas besoin de ?? 'N/A' si nullable
                'password' => Hash::make($validatedData['password']),
                'account_type' => 'teacher',
                'status' => User::STATUS_ACTIVE, // Statut par défaut à la création
                'email_verified_at' => now(),
                'validated_by' => Auth::id(),
                'validated_at' => now(),
            ]);

            $user->teacherProfile()->create([
                'matricule' => $validatedData['matricule'],
                'salary' => $validatedData['salary'],
                'cni' => $validatedData['cni'],
                'birthdate' => $validatedData['birthdate'],
                'birthplace' => $validatedData['birthplace'],
                'profession' => $validatedData['profession'],
                'academy_id' => $validatedData['academy_id'],
                'department_id' => $validatedData['department_id'],
                'center_id' => $validatedData['center_id'],
                'city_id' => $validatedData['city_id'],
            ]);

            $teacherRole = Role::firstOrCreate(['name' => 'enseignant', 'guard_name' => 'web']);
            $user->assignRole($teacherRole);

            DB::commit();
            return redirect()->route('admin.teachers.index', ['locale' => app()->getLocale()])
                ->with('success', 'Enseignant créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Teacher Store Error: ' . $e->getMessage() . ' Stack: ' . $e->getTraceAsString()); // Log plus détaillé
            return back()->withInput()->with('error', 'Erreur lors de la création de l\'enseignant. Veuillez vérifier les informations.');
        }
    }

    public function show($locale, User $teacherUser)
    {
        if ($teacherUser->account_type !== 'teacher' || !$teacherUser->teacherProfile) {
            abort(404);
        }
        $teacherUser->load(['roles', 'teacherProfile.academy', 'teacherProfile.department', 'teacherProfile.center', 'teacherProfile.city', 'validator', 'finalizer']);

        return view('admin.teachers.show', compact('teacherUser'));
    }

    public function edit($locale, User $teacherUser)
    {
        if ($teacherUser->account_type !== 'teacher' || !$teacherUser->teacherProfile) {
            abort(404);
        }
        $teacherUser->load('teacherProfile.city', 'teacherProfile.academy', 'teacherProfile.department', 'teacherProfile.center');

        $academies = Academy::orderBy('name')->pluck('name', 'id');
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $centers = Center::orderBy('name')->pluck('name', 'id'); // Ajouté pour le formulaire d'édition
        $cities = City::where('is_active', true)->orderBy('name')->pluck('name', 'id');
        $genders = User::getGenders();
        $statuses = User::getStatuses();

        return view('admin.teachers.edit', compact('teacherUser', 'academies', 'departments', 'centers', 'cities', 'genders', 'statuses'));
    }

    public function update(Request $request, $locale, User $teacherUser)
    {
        if ($teacherUser->account_type !== 'teacher' || !$teacherUser->teacherProfile) {
            abort(404);
        }

        $teacherProfile = $teacherUser->teacherProfile;

        $validatedUserData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'], // Changé en nullable
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($teacherUser->id)],
            'phone_number' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone_number')->ignore($teacherUser->id)], // Modifié
            'gender' => ['required', Rule::in(array_keys(User::getGenders()))],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(array_keys(User::getStatuses()))],
            // Le mot de passe n'est pas validé ici car il ne sera pas mis à jour depuis ce formulaire
        ]);

        $validatedTeacherProfileData = $request->validate([
            'salary' => ['nullable', 'numeric', 'min:0'],
            'profession' => ['nullable', 'string', 'max:255'],
            'academy_id' => ['nullable', 'exists:academies,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            // Les champs matricule, cni, birthdate, birthplace, center_id ne sont pas modifiables ici
            // s'ils sont déjà définis, donc pas besoin de les valider s'ils ne sont pas soumis.
            // Si vous permettez leur modification s'ils sont vides, ajoutez les règles ici.
        ]);

        DB::beginTransaction();
        try {
            $userDataToUpdate = [
                'first_name' => $validatedUserData['first_name'],
                'last_name' => $validatedUserData['last_name'],
                'email' => $validatedUserData['email'],
                'phone_number' => $validatedUserData['phone_number'],
                'gender' => $validatedUserData['gender'],
                'address' => $validatedUserData['address'],
                'status' => $validatedUserData['status'],
            ];
            // Le mot de passe n'est pas mis à jour ici
            $teacherUser->update($userDataToUpdate);

            $teacherProfileDataToUpdate = [
                'salary' => $validatedTeacherProfileData['salary'],
                'profession' => $validatedTeacherProfileData['profession'],
                'academy_id' => $validatedTeacherProfileData['academy_id'],
                'department_id' => $validatedTeacherProfileData['department_id'],
                'city_id' => $validatedTeacherProfileData['city_id'],
            ];
            // Mettre à jour les champs du profil qui sont modifiables
            $teacherProfile->update($teacherProfileDataToUpdate);

            DB::commit();
            return redirect()->route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id])
                ->with('success', 'Informations de l\'enseignant mises à jour.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Teacher Update Error: ' . $e->getMessage() . ' Stack: ' . $e->getTraceAsString()); // Log plus détaillé
            return back()->withInput()->with('error', 'Erreur lors de la mise à jour de l\'enseignant. Veuillez vérifier les informations.');
        }
    }
    public function destroy($locale, User $teacherUser)
    {
        if ($teacherUser->account_type !== 'teacher' || !$teacherUser->teacherProfile) {
            abort(404);
        }
        if (Auth::id() === $teacherUser->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        DB::beginTransaction();
        try {
            // La suppression du User déclenchera onDelete('cascade') pour TeacherProfile si configuré dans la migration.
            // Sinon, il faut supprimer le profil manuellement avant.
            // $teacherUser->teacherProfile()->delete(); // Si pas de cascade configurée.
            $teacherUser->delete();
            DB::commit();

            return redirect()->route('admin.teachers.index', ['locale' => app()->getLocale()])
                ->with('success', 'Enseignant supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
}
