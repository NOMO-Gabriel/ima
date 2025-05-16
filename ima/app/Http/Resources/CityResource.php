<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'region' => $this->region,
            'country' => $this->country,
            'is_active' => $this->is_active,
            'users_count' => $this->when(isset($this->users_count), $this->users_count),
            'centers_count' => $this->when(isset($this->centers_count), $this->centers_count),
            'financial_directors_count' => $this->when(
                isset($this->financial_directors_count),
                $this->financial_directors_count
            ),
            'logistics_directors_count' => $this->when(
                isset($this->logistics_directors_count),
                $this->logistics_directors_count
            ),
            'financial_agents_count' => $this->when(
                isset($this->financial_agents_count),
                $this->financial_agents_count
            ),
            'created_by' => $this->created_by,
            'creator' => $this->whenLoaded('creator', function () {
                return [
                    'id' => $this->creator->id,
                    'full_name' => $this->creator->full_name,
                ];
            }),
            'updated_by' => $this->updated_by,
            'updater' => $this->whenLoaded('updater', function () {
                return [
                    'id' => $this->updater->id,
                    'full_name' => $this->updater->full_name,
                ];
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
