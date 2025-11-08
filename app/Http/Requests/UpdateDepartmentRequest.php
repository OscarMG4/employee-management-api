<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('department');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:45', Rule::unique('departments', 'name')->ignore($departmentId)],
            'parent_id' => ['nullable', 'exists:departments,id'],
            'level' => ['sometimes', 'required', 'integer', 'min:1'],
            'employee_count' => ['sometimes', 'required', 'integer', 'min:0'],
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
