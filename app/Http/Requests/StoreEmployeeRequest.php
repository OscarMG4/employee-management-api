<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:employees,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'hire_date' => ['nullable', 'date', 'before_or_equal:today'],
            'department' => ['required', 'string', 'max:255'],
            'status' => ['sometimes', Rule::in(['active', 'inactive'])],
            'address' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.max' => 'El apellido no puede exceder los 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'phone.max' => 'El teléfono no puede exceder los 20 caracteres.',
            'position.required' => 'La posición es obligatoria.',
            'salary.required' => 'El salario es obligatorio.',
            'salary.numeric' => 'El salario debe ser un número.',
            'salary.min' => 'El salario debe ser mayor o igual a 0.',
            'hire_date.date' => 'La fecha de contratación debe ser una fecha válida.',
            'hire_date.before_or_equal' => 'La fecha de contratación no puede ser futura.',
            'department.required' => 'El departamento es obligatorio.',
            'status.in' => 'El estado debe ser activo o inactivo.',
            'address.max' => 'La dirección no puede exceder los 500 caracteres.',
            'notes.max' => 'Las notas no pueden exceder los 1000 caracteres.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'position' => 'posición',
            'salary' => 'salario',
            'hire_date' => 'fecha de contratación',
            'department' => 'departamento',
            'status' => 'estado',
            'notes' => 'notas',
        ];
    }
}
