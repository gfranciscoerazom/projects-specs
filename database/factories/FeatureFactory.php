<?php

namespace Database\Factories;

use App\Enums\Feature\FeaturePriority;
use App\Enums\Feature\FeatureStatus;
use App\Enums\Feature\FeatureType;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'plan' => fake()->text(),
            'status' => fake()->randomElement(FeatureStatus::class),
            'priority' => fake()->randomElement(FeaturePriority::class),
            'type' => fake()->randomElement(FeatureType::class),
            'sort' => fake()->numberBetween(0, 10000),
            'project_id' => Project::factory(),
        ];
    }
}
