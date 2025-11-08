<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'parent' => $this->when($this->parent, function() {
                return [
                    'id' => $this->parent->id,
                    'name' => $this->parent->name,
                ];
            }),
            'level' => $this->level,
            'employee_count' => $this->employee_count,
            'ambassador_name' => $this->ambassador_name,
            'children_count' => $this->children->count(),
            'children' => DepartmentResource::collection($this->whenLoaded('children')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
