<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => fake()->sentence(),
            'age' => fake()->numberBetween(18, 65),
            'company' => fake()->sentence(),
           'address' => fake()->text(255),
            'email' => fake()->safeEmail()
        ];
    }
}
