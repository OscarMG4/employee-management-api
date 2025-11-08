<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test listing employees.
     */
    public function test_can_list_employees(): void
    {
        Employee::factory()->count(5)->create();

        $response = $this->getJson('/api/employees');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'position',
                        'salary',
                        'hire_date',
                        'department',
                        'status',
                    ]
                ],
                'links',
                'meta'
            ]);
    }

    /**
     * Test creating an employee.
     */
    public function test_can_create_employee(): void
    {
        $employeeData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Developer',
            'salary' => 75000,
            'hire_date' => '2024-01-15',
            'department' => 'Engineering',
            'status' => 'active',
        ];

        $response = $this->postJson('/api/employees', $employeeData);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'John Doe']);

        $this->assertDatabaseHas('employees', ['email' => 'john@example.com']);
    }

    /**
     * Test validation when creating employee.
     */
    public function test_employee_creation_requires_validation(): void
    {
        $response = $this->postJson('/api/employees', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'position', 'salary', 'hire_date', 'department']);
    }

    /**
     * Test showing a specific employee.
     */
    public function test_can_show_employee(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->getJson("/api/employees/{$employee->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $employee->id]);
    }

    /**
     * Test updating an employee.
     */
    public function test_can_update_employee(): void
    {
        $employee = Employee::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'position' => 'Senior Developer',
        ];

        $response = $this->putJson("/api/employees/{$employee->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Updated Name',
        ]);
    }

    /**
     * Test deleting an employee.
     */
    public function test_can_delete_employee(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->deleteJson("/api/employees/{$employee->id}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('employees', ['id' => $employee->id]);
    }

    /**
     * Test searching employees.
     */
    public function test_can_search_employees(): void
    {
        Employee::factory()->create(['name' => 'John Smith']);
        Employee::factory()->create(['name' => 'Jane Doe']);

        $response = $this->getJson('/api/employees?search=John');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'John Smith']);
    }

    /**
     * Test filtering employees by department.
     */
    public function test_can_filter_by_department(): void
    {
        Employee::factory()->create(['department' => 'Engineering']);
        Employee::factory()->create(['department' => 'Sales']);

        $response = $this->getJson('/api/employees?department=Engineering');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertTrue(count($data) >= 1);
    }

    /**
     * Test getting employee statistics.
     */
    public function test_can_get_statistics(): void
    {
        Employee::factory()->count(10)->create();

        $response = $this->getJson('/api/employees/statistics');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total_employees',
                'active_employees',
                'inactive_employees',
                'average_salary',
                'total_payroll',
            ]);
    }

    /**
     * Test getting unique departments.
     */
    public function test_can_get_departments(): void
    {
        Employee::factory()->create(['department' => 'Engineering']);
        Employee::factory()->create(['department' => 'Sales']);

        $response = $this->getJson('/api/employees/departments');

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }
}
