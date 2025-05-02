<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name, // Attribut virtuel défini dans le modèle
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'city_id' => $this->city_id,
            'city' => $this->whenLoaded('city', function () {
                return new CityResource($this->city);
            }),
            'address' => $this->address,
            'account_type' => $this->account_type,
            'profile_photo_url' => $this->profile_photo_url, // Attribut virtuel défini dans le modèle
            'status' => $this->status,
            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->pluck('name');
            }),
            'permissions' => $this->when($request->user() && $request->user()->can('manage users'), function () {
                return $this->getAllPermissions()->pluck('name');
            }),
            'directed_academies' => $this->whenLoaded('directedAcademies', function () {
                return AcademyResource::collection($this->directedAcademies);
            }),
            'headed_departments' => $this->whenLoaded('headedDepartments', function () {
                return DepartmentResource::collection($this->headedDepartments);
            }),
            'directed_centers' => $this->whenLoaded('directedCenters', function () {
                return CenterResource::collection($this->directedCenters);
            }),
            'last_login_at' => $this->last_login_at ? $this->last_login_at->format('Y-m-d H:i:s') : null,
            'email_verified_at' => $this->email_verified_at ? $this->email_verified_at->format('Y-m-d H:i:s') : null,
            'validated_at' => $this->validated_at ? $this->validated_at->format('Y-m-d H:i:s') : null,
            'finalized_at' => $this->finalized_at ? $this->finalized_at->format('Y-m-d H:i:s') : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
