<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Report;
use App\Models\Dossier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
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
        ];
    }

    public function report(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'bookmarkable_type' => 'reports',
                'bookmarkable_id' => Report::factory(),
            ];
        });
    }

    public function dossier(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'bookmarkable_type' => 'dossiers',
                'bookmarkable_id' => Dossier::factory(),
            ];
        });
    }
}
