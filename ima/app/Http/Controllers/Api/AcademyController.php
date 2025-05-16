<?php

namespace App\Http\Controllers\Api;

use App\Models\Academy;
use Illuminate\Http\Request;
use App\Http\Resources\AcademyResource;
use Illuminate\Http\JsonResponse;

class AcademyController extends ApiController
{
    /**
     * Afficher une liste des académies
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Academy::query()->with(['director', 'departments', 'centers']);

        // Filtrage par statut
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Filtrage par directeur
        if ($request->has('director_id')) {
            $query->where('director_id', $request->director_id);
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
        $academies = $query->paginate($perPage);

        return $this->sendResponse(
            AcademyResource::collection($academies)->response()->getData(true)
        );
    }

    /**
     * Créer une nouvelle académie
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:academies'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'director_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);

        $academy = Academy::create(array_merge(
            $request->all(),
            [
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id
            ]
        ));

        $academy->load(['director', 'creator', 'updater']);

        return $this->sendResponse(
            new AcademyResource($academy),
            'Académie créée avec succès',
            201
        );
    }

    /**
     * Afficher une académie spécifique
     *
     * @param Academy $academy
     * @return JsonResponse
     */
    public function show(Academy $academy): JsonResponse
    {
        $academy->load(['director', 'departments', 'centers', 'creator', 'updater']);

        return $this->sendResponse(new AcademyResource($academy));
    }

    /**
     * Mettre à jour une académie
     *
     * @param Request $request
     * @param Academy $academy
     * @return JsonResponse
     */
    public function update(Request $request, Academy $academy): JsonResponse
    {
        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'code' => ['sometimes', 'required', 'string', 'max:50', 'unique:academies,code,'.$academy->id],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'director_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);

        $academy->update(array_merge(
            $request->all(),
            ['updated_by' => $request->user()->id]
        ));

        $academy->load(['director', 'creator', 'updater']);

        return $this->sendResponse(
            new AcademyResource($academy),
            'Académie mise à jour avec succès'
        );
    }

    /**
     * Supprimer une académie
     *
     * @param Academy $academy
     * @return JsonResponse
     */
    public function destroy(Academy $academy): JsonResponse
    {
        // Vérifier si l'académie a des départements ou des centres
        if ($academy->departments()->count() > 0 || $academy->centers()->count() > 0) {
            return $this->sendError(
                'Impossible de supprimer cette académie car elle contient des départements ou des centres.',
                [],
                422
            );
        }

        $academy->delete();

        return $this->sendResponse([], 'Académie supprimée avec succès');
    }

    /**
     * Changer le statut d'une académie
     *
     * @param Request $request
     * @param Academy $academy
     * @return JsonResponse
     */
    public function toggleStatus(Request $request, Academy $academy): JsonResponse
    {
        $academy->is_active = !$academy->is_active;
        $academy->updated_by = $request->user()->id;
        $academy->save();

        return $this->sendResponse(
            new AcademyResource($academy),
            'Statut de l\'académie mis à jour avec succès'
        );
    }
}
