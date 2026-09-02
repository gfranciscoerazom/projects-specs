<?php

namespace Database\Factories;

use App\Enums\PlanTask\PlanTaskStatus;
use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'task' => fake()->word(),
            'description' => fake()->text(),
            'status' => fake()->randomElement(PlanTaskStatus::class),
            'sort' => fake()->numberBetween(0, 10000),
            'feature_id' => Feature::factory(),
        ];
    }
}
