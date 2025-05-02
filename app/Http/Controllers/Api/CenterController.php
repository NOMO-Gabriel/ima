<?php

namespace App\Http\Controllers\Api;

use App\Models\Center;
use Illuminate\Http\Request;
use App\Http\Resources\CenterResource;
use Illuminate\Http\JsonResponse;

class CenterController extends ApiController
{
    /**
     * Afficher une liste des centres
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Center::query()->with(['academy', 'director']);

        // Filtrage par académie
        if ($request->has('academy_id')) {
            $query->where('academy_id', $request->academy_id);
        }

        // Filtrage par statut
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Filtrage par directeur
        if ($request->has('director_id')) {
            $query->where('director_id', $request->director_id);
        }

        // Filtrage par ville
        if ($request->has('city')) {
            $query->where('city', 'like', "%{$request->city}%");
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
        $centers = $query->paginate($perPage);

        return $this->sendResponse(
            CenterResource::collection($centers)->response()->getData(true)
        );
    }

    /**
     * Créer un nouveau centre
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:centers'],
            'description' => ['nullable', 'string'],
            'academy_id' => ['required', 'exists:academies,id'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'director_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);

        $center = Center::create(array_merge(
            $request->all(),
            [
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id
            ]
        ));

        $center->load(['academy', 'director', 'creator', 'updater']);

        return $this->sendResponse(
            new CenterResource($center),
            'Centre créé avec succès',
            201
        );
    }

    /**
     * Afficher un centre spécifique
     *
     * @param Center $center
     * @return JsonResponse
     */
    public function show(Center $center): JsonResponse
    {
        $center->load(['academy', 'director', 'creator', 'updater']);

        return $this->sendResponse(new CenterResource($center));
    }

    /**
     * Mettre à jour un centre
     *
     * @param Request $request
     * @param Center $center
     * @return JsonResponse
     */
    public function update(Request $request, Center $center): JsonResponse
    {
        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'code' => ['sometimes', 'required', 'string', 'max:50', 'unique:centers,code,'.$center->id],
            'description' => ['nullable', 'string'],
            'academy_id' => ['sometimes', 'required', 'exists:academies,id'],
            'city' => ['sometimes', 'required', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'director_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);

        $center->update(array_merge(
            $request->all(),
            ['updated_by' => $request->user()->id]
        ));

        $center->load(['academy', 'director', 'creator', 'updater']);

        return $this->sendResponse(
            new CenterResource($center),
            'Centre mis à jour avec succès'
        );
    }

    /**
     * Supprimer un centre
     *
     * @param Center $center
     * @return JsonResponse
     */
    public function destroy(Center $center): JsonResponse
    {
        // Vérifier si des données sont liées à ce centre
        // (Selon votre modèle de données, ajoutez d'autres vérifications si nécessaire)

        $center->delete();

        return $this->sendResponse([], 'Centre supprimé avec succès');
    }

    /**
     * Changer le statut d'un centre
     *
     * @param Request $request
     * @param Center $center
     * @return JsonResponse
     */
    public function toggleStatus(Request $request, Center $center): JsonResponse
    {
        $center->is_active = !$center->is_active;
        $center->updated_by = $request->user()->id;
        $center->save();

        return $this->sendResponse(
            new CenterResource($center),
            'Statut du centre mis à jour avec succès'
        );
    }

    /**
     * Récupérer les centres par académie
     *
     * @param Request $request
     * @param int $academyId
     * @return JsonResponse
     */
    public function getByAcademy(Request $request, int $academyId): JsonResponse
    {
        $query = Center::where('academy_id', $academyId)
            ->with(['director']);

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
        $centers = $query->paginate($perPage);

        return $this->sendResponse(
            CenterResource::collection($centers)->response()->getData(true)
        );
    }
}
