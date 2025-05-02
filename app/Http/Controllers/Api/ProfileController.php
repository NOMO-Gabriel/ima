<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class ProfileController extends ApiController
{
    /**
     * Récupérer le profil de l'utilisateur authentifié
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->load(['roles', 'directedAcademies', 'headedDepartments', 'directedCenters']);

        return $this->sendResponse(new UserResource($user));
    }

    /**
     * Mettre à jour le profil de l'utilisateur
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone_number' => ['sometimes', 'required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update($request->only([
            'first_name', 'last_name', 'email', 'phone_number', 'address'
        ]));

        return $this->sendResponse(
            new UserResource($user),
            'Profil mis à jour avec succès'
        );
    }

    /**
     * Changer le mot de passe de l'utilisateur
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = $request->user();

        // Vérifier le mot de passe actuel
        if (!Hash::check($request->current_password, $user->password)) {
            return $this->sendError(
                'Le mot de passe actuel est incorrect',
                ['current_password' => ['Le mot de passe actuel est incorrect']],
                422
            );
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return $this->sendResponse([], 'Mot de passe changé avec succès');
    }

    /**
     * Mettre à jour la photo de profil de l'utilisateur
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfilePhoto(Request $request): JsonResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'], // 2MB max
        ]);

        $user = $request->user();

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
}
