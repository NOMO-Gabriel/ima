<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'academy_id' => $this->academy_id,
            'academy' => $this->whenLoaded('academy', function () {
                return [
                    'id' => $this->academy->id,
                    'name' => $this->academy->name,
                    'code' => $this->academy->code,
                ];
            }),
            'head_id' => $this->head_id,
            'head' => $this->whenLoaded('head', function () {
                return new UserResource($this->head);
            }),
            'is_active' => $this->is_active,
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
