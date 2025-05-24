<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends ApiController
{
    /**
     * Afficher une liste des utilisateurs
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::query()->with('roles');

        // Filtrage par rôle
        if ($request->has('role')) {
            $query->role($request->role);
        }

        // Filtrage par statut
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filtrage par ville
        if ($request->has('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Recherche par nom ou email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        // Tri
        $sortField = $request->sort_field ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $query->orderBy($sortField, $sortOrder);

        // Pagination
        $perPage = $request->per_page ?? 15;
        $users = $query->paginate($perPage);

        return $this->sendResponse(
            UserResource::collection($users)->response()->getData(true)
        );
    }

    /**
     * Créer un nouvel utilisateur
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'max:20'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'status' => ['required', 'string', 'in:active,pending,inactive'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'status' => $request->status,
        ]);

        // Assigner le rôle avec la méthode personnalisée
        $user->myAssignRole($request->role);

        return $this->sendResponse(
            new UserResource($user),
            'Utilisateur créé avec succès',
            201
        );
    }

    /**
     * Afficher un utilisateur spécifique
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        // Charger les relations
        $user->load(['roles', 'directedAcademies', 'headedDepartments', 'directedCenters']);

        return $this->sendResponse(new UserResource($user));
    }

    /**
     * Mettre à jour un utilisateur
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone_number' => ['sometimes', 'required', 'string', 'max:20'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'required', 'string', 'in:active,pending,inactive'],
        ]);

        $user->update($request->except(['password', 'role']));

        // Mettre à jour le rôle si fourni
        if ($request->has('role')) {
            $user->roles()->detach();
            $user->myAssignRole($request->role);
        }

        // Mettre à jour le mot de passe si fourni
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', Rules\Password::defaults()],
            ]);

            $user->password = Hash::make($request->password);
            $user->save();
        }

        return $this->sendResponse(
            new UserResource($user),
            'Utilisateur mis à jour avec succès'
        );
    }

    /**
     * Supprimer un utilisateur
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        // Vérifier si l'utilisateur peut être supprimé
        if ($user->directedAcademies()->count() > 0 ||
            $user->headedDepartments()->count() > 0 ||
            $user->directedCenters()->count() > 0) {
            return $this->sendError(
                'Impossible de supprimer cet utilisateur car il est associé à des académies, départements ou centres.',
                [],
                422
            );
        }

        // Supprimer la photo de profil si elle existe
        if ($user->profile_photo_path) {
            Storage::delete('public/' . $user->profile_photo_path);
        }

        $user->delete();

        return $this->sendResponse([], 'Utilisateur supprimé avec succès');
    }

    /**
     * Mettre à jour la photo de profil
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function updateProfilePhoto(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'], // 2MB max
        ]);

        // Supprimer l'ancienne photo si elle existe
        if ($user->profile_photo_path) {
            Storage::delete('public/' . $user->profile_photo_path);
        }

        // Stocker la nouvelle photo
        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->profile_photo_path = $path;
        $user->save();

        return $this->sendResponse([
            'photo_url' => $user->profile_photo_url
        ], 'Photo de profil mise à jour avec succès');
    }

    /**
     * Rechercher des utilisateurs
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2'
        ]);

        $query = $request->query;

        $users = User::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone_number', 'like', "%{$query}%")
            ->with('roles')
            ->paginate(15);

        return $this->sendResponse(
            UserResource::collection($users)->response()->getData(true)
        );
    }

    /**
     * Modifier le statut d'un utilisateur
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function updateStatus(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:active,pending,inactive'],
        ]);

        $user->status = $request->status;

        // Si l'utilisateur est activé, définir la date de validation
        if ($request->status === 'active' && !$user->validated_at) {
            $user->validated_at = now();
        }

        $user->save();

        return $this->sendResponse(
            new UserResource($user),
            'Statut de l\'utilisateur mis à jour avec succès'
        );
    }
}
