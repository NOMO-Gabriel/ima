<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Resources\DepartmentResource;
use Illuminate\Http\JsonResponse;

class DepartmentController extends ApiController
{
    /**
     * Afficher une liste des départements
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Department::query()->with(['academy', 'head']);

        // Filtrage par académie
        if ($request->has('academy_id')) {
            $query->where('academy_id', $request->academy_id);
        }

        // Filtrage par statut
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Filtrage par responsable
        if ($request->has('head_id')) {
            $query->where('head_id', $request->head_id);
        }

        // Recherche par nom ou code
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Tri
        $sortField = $request->sort_field ?? 'name';
        $sortOrder = $request->sort_order ?? 'asc';
        $query->orderBy($sortField, $sortOrder);

        // Pagination
        $perPage = $request->per_page ?? 15;
        $departments = $query->paginate($perPage);

        return $this->sendResponse(
            DepartmentResource::collection($departments)->response()->getData(true)
        );
    }

    /**
     * Créer un nouveau département
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:departments'],
            'description' => ['nullable', 'string'],
            'academy_id' => ['required', 'exists:academies,id'],
            'head_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);

        $department = Department::create(array_merge(
            $request->all(),
            [
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id
            ]
        ));

        $department->load(['academy', 'head', 'creator', 'updater']);

        return $this->sendResponse(
            new DepartmentResource($department),
            'Département créé avec succès',
            201
        );
    }

    /**
     * Afficher un département spécifique
     *
     * @param Department $department
     * @return JsonResponse
     */
    public function show(Department $department): JsonResponse
    {
        $department->load(['academy', 'head', 'creator', 'updater']);

        return $this->sendResponse(new DepartmentResource($department));
    }

    /**
     * Mettre à jour un département
     *
     * @param Request $request
     * @param Department $department
     * @return JsonResponse
     */
    public function update(Request $request, Department $department): JsonResponse
    {
        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'code' => ['sometimes', 'required', 'string', 'max:50', 'unique:departments,code,'.$department->id],
            'description' => ['nullable', 'string'],
            'academy_id' => ['sometimes', 'required', 'exists:academies,id'],
            'head_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);

        $department->update(array_merge(
            $request->all(),
            ['updated_by' => $request->user()->id]
        ));

        $department->load(['academy', 'head', 'creator', 'updater']);

        return $this->sendResponse(
            new DepartmentResource($department),
            'Département mis à jour avec succès'
        );
    }

    /**
     * Supprimer un département
     *
     * @param Department $department
     * @return JsonResponse
     */
    public function destroy(Department $department): JsonResponse
    {
        // Vérifier si des données sont liées à ce département
        // (Selon votre modèle de données, ajoutez d'autres vérifications si nécessaire)

        $department->delete();

        return $this->sendResponse([], 'Département supprimé avec succès');
    }

    /**
     * Changer le statut d'un département
     *
     * @param Request $request
     * @param Department $department
     * @return JsonResponse
     */
    public function toggleStatus(Request $request, Department $department): JsonResponse
    {
        $department->is_active = !$department->is_active;
        $department->updated_by = $request->user()->id;
        $department->save();

        return $this->sendResponse(
            new DepartmentResource($department),
            'Statut du département mis à jour avec succès'
        );
    }

    /**
     * Récupérer les départements par académie
     *
     * @param Request $request
     * @param int $academyId
     * @return JsonResponse
     */
    public function getByAcademy(Request $request, int $academyId): JsonResponse
    {
        $query = Department::where('academy_id', $academyId)
            ->with(['head']);

        // Filtrage par statut
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Tri
        $sortField = $request->sort_field ?? 'name';
        $sortOrder = $request->sort_order ?? 'asc';
        $query->orderBy($sortField, $sortOrder);

        // Pagination
        $perPage = $request->per_page ?? 15;
        $departments = $query->paginate($perPage);

        return $this->sendResponse(
            DepartmentResource::collection($departments)->response()->getData(true)
        );
    }
}
