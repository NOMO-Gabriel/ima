<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;

class PermissionController extends ApiController
{
    /**
     * Afficher une liste des permissions
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $permissions = Permission::all();

        return $this->sendResponse($permissions);
    }

    /**
     * Créer une nouvelle permission
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        $permission = Permission::create(['name' => $request->name]);

        return $this->sendResponse(
            $permission,
            'Permission créée avec succès',
            201
        );
    }

    /**
     * Afficher une permission spécifique
     *
     * @param Permission $permission
     * @return JsonResponse
     */
    public function show(Permission $permission): JsonResponse
    {
        return $this->sendResponse($permission);
    }

    /**
     * Mettre à jour une permission
     *
     * @param Request $request
     * @param Permission $permission
     * @return JsonResponse
     */
    public function update(Request $request, Permission $permission): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,'.$permission->id],
        ]);

        $permission->name = $request->name;
        $permission->save();

        return $this->sendResponse(
            $permission,
            'Permission mise à jour avec succès'
        );
    }

    /**
     * Supprimer une permission
     *
     * @param Permission $permission
     * @return JsonResponse
     */
    public function destroy(Permission $permission): JsonResponse
    {
        // Vérifier si cette permission est utilisée par des rôles
        if ($permission->roles()->count() > 0) {
            return $this->sendError(
                'Impossible de supprimer cette permission car elle est utilisée par des rôles.',
                [],
                422
            );
        }

        $permission->delete();

        return $this->sendResponse([], 'Permission supprimée avec succès');
    }

    /**
     * Obtenir les rôles avec une permission spécifique
     *
     * @param Permission $permission
     * @return JsonResponse
     */
    public function getRoles(Permission $permission): JsonResponse
    {
        $roles = $permission->roles;

        return $this->sendResponse([
            'permission' => $permission->name,
            'roles' => $roles
        ]);
    }
}
