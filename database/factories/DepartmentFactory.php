<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prefixes = ['Área de', 'Equipo de', 'División de', 'Grupo de', 'Sección de', 'Unidad de'];
        $departments = [
            'Recursos Humanos',
            'Tecnología',
            'Finanzas',
            'Marketing',
            'Ventas',
            'Operaciones',
            'Legal',
            'Administración',
            'Desarrollo',
            'Soporte',
            'Investigación',
            'Producción',
            'Calidad',
            'Logística',
            'Compras',
        ];

        return [
            'name' => fake()->randomElement($prefixes) . ' ' . fake()->randomElement($departments) . ' ' . fake()->unique()->numberBetween(1, 10000),
            'level' => fake()->numberBetween(1, 5),
            'employee_count' => fake()->numberBetween(5, 150),
            'ambassador_name' => fake()->name(),
        ];
    }
}
