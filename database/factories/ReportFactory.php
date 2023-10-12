<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'summary' => fake()->sentence(),
            'country' => fake()->country(),
            'state' => fake()->state(),
            'city' => fake()->city(),
            'lat' => fake()->latitude(),
            'long' => fake()->longitude(),
            'date' => fake()->dateTimeBetween(),
            'duration' => fake()->numberBetween(1, 60),
            'object_shape' => fake()->word(),
            'number_of_observers' => fake()->numberBetween(1, 10),
            'details' => fake()->text(),
        ];
    }
}
