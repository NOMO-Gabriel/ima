<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends ApiController
{
    /**
     * Afficher une liste des rôles
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $roles = Role::with('permissions')->get();

        return $this->sendResponse($roles);
    }

    /**
     * Créer un nouveau rôle
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return $this->sendResponse(
            $role->load('permissions'),
            'Rôle créé avec succès',
            201
        );
    }

    /**
     * Afficher un rôle spécifique
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        return $this->sendResponse($role->load('permissions'));
    }

    /**
     * Mettre à jour un rôle
     *
     * @param Request $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(Request $request, Role $role): JsonResponse
    {
        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255', 'unique:roles,name,'.$role->id],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        if ($request->has('name')) {
            $role->name = $request->name;
            $role->save();
        }

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return $this->sendResponse(
            $role->load('permissions'),
            'Rôle mis à jour avec succès'
        );
    }

    /**
     * Supprimer un rôle
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        // Vérifier si des utilisateurs ont ce rôle
        if ($role->users()->count() > 0) {
            return $this->sendError(
                'Impossible de supprimer ce rôle car il est attribué à des utilisateurs.',
                [],
                422
            );
        }

        $role->delete();

        return $this->sendResponse([], 'Rôle supprimé avec succès');
    }

    /**
     * Attribuer des permissions à un rôle
     *
     * @param Request $request
     * @param Role $role
     * @return JsonResponse
     */
    public function assignPermissions(Request $request, Role $role): JsonResponse
    {
        $request->validate([
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return $this->sendResponse(
            $role->load('permissions'),
            'Permissions attribuées avec succès'
        );
    }

    /**
     * Obtenir les utilisateurs avec un rôle spécifique
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function getUsers(Role $role): JsonResponse
    {
        $users = $role->users()->paginate(15);

        return $this->sendResponse([
            'role' => $role->name,
            'users' => $users
        ]);
    }
}
