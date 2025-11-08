<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departments = [
            'Engineering',
            'Sales',
            'Marketing',
            'Human Resources',
            'Finance',
            'Operations',
            'Customer Support',
            'Product',
            'Design',
            'Legal'
        ];

        $positions = [
            'Junior Developer',
            'Senior Developer',
            'Team Lead',
            'Project Manager',
            'Product Manager',
            'Sales Representative',
            'Marketing Specialist',
            'HR Manager',
            'Financial Analyst',
            'Operations Manager',
            'Support Specialist',
            'UX Designer',
            'UI Designer',
            'Legal Counsel'
        ];

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional(0.7)->phoneNumber(),
            'position' => fake()->randomElement($positions),
            'salary' => fake()->randomFloat(2, 30000, 150000),
            'hire_date' => fake()->dateTimeBetween('-10 years', 'now'),
            'department' => fake()->randomElement($departments),
            'status' => fake()->randomElement(['active', 'active', 'active', 'inactive']), // 75% activos
            'address' => fake()->optional(0.5)->address(),
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    public function department(string $department): static
    {
        return $this->state(fn (array $attributes) => [
            'department' => $department,
        ]);
    }
}
