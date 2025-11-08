<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:45', 'unique:departments,name'],
            'parent_id' => ['nullable', 'exists:departments,id'],
            'level' => ['required', 'integer', 'min:1'],
            'employee_count' => ['required', 'integer', 'min:0'],
            'ambassador_name' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.unique' => 'Ya existe un departamento con este nombre.',
            'name.max' => 'El nombre no puede exceder 45 caracteres.',
            'parent_id.exists' => 'El departamento superior no existe.',
            'level.required' => 'El nivel es obligatorio.',
            'level.min' => 'El nivel debe ser al menos 1.',
            'employee_count.required' => 'La cantidad de empleados es obligatoria.',
            'employee_count.min' => 'La cantidad de empleados debe ser al menos 0.',
        ];
    }
}
