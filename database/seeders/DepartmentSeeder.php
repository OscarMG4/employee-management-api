<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $rootDepts = [
            ['name' => 'Recursos Humanos', 'level' => 1, 'employee_count' => 25, 'ambassador_name' => 'Ana García López'],
            ['name' => 'Tecnología', 'level' => 1, 'employee_count' => 45, 'ambassador_name' => 'Carlos Martínez Silva'],
            ['name' => 'Finanzas', 'level' => 1, 'employee_count' => 30, 'ambassador_name' => 'María Rodríguez Pérez'],
            ['name' => 'Marketing', 'level' => 1, 'employee_count' => 20, 'ambassador_name' => 'Luis Fernández Torres'],
            ['name' => 'Ventas', 'level' => 1, 'employee_count' => 35, 'ambassador_name' => 'Laura Sánchez Ruiz'],
        ];

        foreach ($rootDepts as $dept) {
            $parent = Department::create($dept);

            $subDepts = [
                'Recursos Humanos' => [
                    ['name' => 'Reclutamiento', 'level' => 2, 'employee_count' => 8],
                    ['name' => 'Capacitación', 'level' => 2, 'employee_count' => 12],
                ],
                'Tecnología' => [
                    ['name' => 'Desarrollo', 'level' => 2, 'employee_count' => 25],
                    ['name' => 'Infraestructura', 'level' => 2, 'employee_count' => 15],
                    ['name' => 'Soporte', 'level' => 2, 'employee_count' => 10],
                ],
                'Finanzas' => [
                    ['name' => 'Contabilidad', 'level' => 2, 'employee_count' => 15],
                    ['name' => 'Tesorería', 'level' => 2, 'employee_count' => 10],
                ],
                'Marketing' => [
                    ['name' => 'Digital', 'level' => 2, 'employee_count' => 12],
                    ['name' => 'Contenidos', 'level' => 2, 'employee_count' => 8],
                ],
                'Ventas' => [
                    ['name' => 'Corporativas', 'level' => 2, 'employee_count' => 18],
                    ['name' => 'Retail', 'level' => 2, 'employee_count' => 17],
                ],
            ];

            if (isset($subDepts[$parent->name])) {
                foreach ($subDepts[$parent->name] as $subDept) {
                    $subDept['parent_id'] = $parent->id;
                    $subDept['ambassador_name'] = fake()->name();
                    Department::create($subDept);
                }
            }
        }

        Department::factory()->count(15)->create();
    }
}
