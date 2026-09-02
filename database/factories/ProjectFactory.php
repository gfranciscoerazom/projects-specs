<?php

namespace Database\Factories;

use App\Enums\Project\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'audience' => fake()->word(),
            'status' => fake()->randomElement(ProjectStatus::class),
            'conventions' => fake()->text(),
        ];
    }
}
