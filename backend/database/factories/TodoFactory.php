<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'completed' => $this->faker->boolean(),
            'priority' => $this->faker->numberBetween(1, 3),
            'status' => $this->faker->randomElement(['doing', 'done']),
            'deadline' => $this->faker->dateTimeBetween('now', '+10 minutes'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
