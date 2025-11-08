<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::factory()->count(50)->create();

        Employee::factory()->create([
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'email' => 'juan.perez@helios.com',
            'position' => 'CEO',
            'department' => 'Executive',
            'salary' => 200000,
            'hire_date' => now()->subYears(5),
            'status' => 'active',
        ]);

        Employee::factory()->create([
            'first_name' => 'María',
            'last_name' => 'García',
            'email' => 'maria.garcia@helios.com',
            'position' => 'CTO',
            'department' => 'Engineering',
            'salary' => 180000,
            'hire_date' => now()->subYears(4),
            'status' => 'active',
        ]);

        Employee::factory()->create([
            'first_name' => 'Carlos',
            'last_name' => 'Rodríguez',
            'email' => 'carlos.rodriguez@helios.com',
            'position' => 'Senior Developer',
            'department' => 'Engineering',
            'salary' => 95000,
            'hire_date' => now()->subYears(3),
            'status' => 'active',
        ]);
    }
}
