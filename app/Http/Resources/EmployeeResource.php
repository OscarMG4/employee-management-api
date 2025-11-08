<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'position' => $this->position,
            'salary' => (float) $this->salary,
            'hire_date' => $this->hire_date?->format('Y-m-d'),
            'department' => $this->department,
            'status' => $this->status,
            'address' => $this->address,
            'notes' => $this->notes,
            'years_of_service' => $this->years_of_service,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
