<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Resources\CityResource;
use Illuminate\Http\JsonResponse;

class CityController extends ApiController
{
    /**
     * Afficher une liste des villes
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = City::query();

        // Filtrage par région
        if ($request->has('region')) {
            $query->where('region', $request->region);
        }

        // Filtrage par pays
        if ($request->has('country')) {
            $query->where('country', $request->country);
        }

        // Filtrage par statut
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
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
        $cities = $query->paginate($perPage);

        return $this->sendResponse(
            CityResource::collection($cities)->response()->getData(true)
        );
    }

    /**
     * Créer une nouvelle ville
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:cities'],
            'description' => ['nullable', 'string'],
            'region' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'is_active' => ['boolean'],
        ]);

        $city = City::create(array_merge(
            $request->all(),
            [
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id
            ]
        ));

        $city->load(['creator', 'updater']);

        return $this->sendResponse(
            new CityResource($city),
            'Ville créée avec succès',
            201
        );
    }

    /**
     * Afficher une ville spécifique
     *
     * @param City $city
     * @return JsonResponse
     */
    public function show(City $city): JsonResponse
    {
        $city->load(['creator', 'updater']);

        return $this->sendResponse(new CityResource($city));
    }

    /**
     * Mettre à jour une ville
     *
     * @param Request $request
     * @param City $city
     * @return JsonResponse
     */
    public function update(Request $request, City $city): JsonResponse
    {
        $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'code' => ['sometimes', 'required', 'string', 'max:50', 'unique:cities,code,'.$city->id],
            'description' => ['nullable', 'string'],
            'region' => ['sometimes', 'required', 'string', 'max:100'],
            'country' => ['sometimes', 'required', 'string', 'max:100'],
            'is_active' => ['boolean'],
        ]);

        $city->update(array_merge(
            $request->all(),
            ['updated_by' => $request->user()->id]
        ));

        $city->load(['creator', 'updater']);

        return $this->sendResponse(
            new CityResource($city),
            'Ville mise à jour avec succès'
        );
    }

    /**
     * Supprimer une ville
     *
     * @param City $city
     * @return JsonResponse
     */
    public function destroy(City $city): JsonResponse
    {
        // Vérifier si des utilisateurs ou des centres sont associés à cette ville
        if ($city->users()->count() > 0 || $city->centers()->count() > 0) {
            return $this->sendError(
                'Impossible de supprimer cette ville car elle est associée à des utilisateurs ou des centres.',
                [],
                422
            );
        }

        $city->delete();

        return $this->sendResponse([], 'Ville supprimée avec succès');
    }

    /**
     * Changer le statut d'une ville
     *
     * @param Request $request
     * @param City $city
     * @return JsonResponse
     */
    public function toggleStatus(Request $request, City $city): JsonResponse
    {
        $city->is_active = !$city->is_active;
        $city->updated_by = $request->user()->id;
        $city->save();

        return $this->sendResponse(
            new CityResource($city),
            'Statut de la ville mis à jour avec succès'
        );
    }

    /**
     * Récupérer les villes par région
     *
     * @param Request $request
     * @param string $region
     * @return JsonResponse
     */
    public function getByRegion(Request $request, string $region): JsonResponse
    {
        $query = City::where('region', $region);

        // Filtrage par statut
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Tri
        $sortField = $request->sort_field ?? 'name';
        $sortOrder = $request->sort_order ?? 'asc';
        $query->orderBy($sortField, $sortOrder);

        // Pagination ou récupération de toutes les villes
        if ($request->has('per_page')) {
            $cities = $query->paginate($request->per_page);
            return $this->sendResponse(
                CityResource::collection($cities)->response()->getData(true)
            );
        } else {
            $cities = $query->get();
            return $this->sendResponse(
                CityResource::collection($cities)
            );
        }
    }

    /**
     * Récupérer les directeurs financiers d'une ville
     *
     * @param City $city
     * @return JsonResponse
     */
    public function getFinancialDirectors(City $city): JsonResponse
    {
        $directors = $city->financialDirectors()->get();

        return $this->sendResponse([
            'city' => new CityResource($city),
            'financial_directors' => $directors
        ]);
    }

    /**
     * Récupérer les directeurs logistiques d'une ville
     *
     * @param City $city
     * @return JsonResponse
     */
    public function getLogisticsDirectors(City $city): JsonResponse
    {
        $directors = $city->logisticsDirectors()->get();

        return $this->sendResponse([
            'city' => new CityResource($city),
            'logistics_directors' => $directors
        ]);
    }

    /**
     * Récupérer les agents financiers d'une ville
     *
     * @param City $city
     * @return JsonResponse
     */
    public function getFinancialAgents(City $city): JsonResponse
    {
        $agents = $city->financialAgents()->get();

        return $this->sendResponse([
            'city' => new CityResource($city),
            'financial_agents' => $agents
        ]);
    }
}
