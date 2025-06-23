<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['class', 'brand', 'document', 'condition'];

        return [
            'name' => $this->faker->words(2, true),
            'type' => $this->faker->randomElement($types),
            'description' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the category is of type 'class'.
     */
    public function class(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'class',
        ]);
    }

    /**
     * Indicate that the category is of type 'brand'.
     */
    public function brand(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'brand',
        ]);
    }

    /**
     * Indicate that the category is of type 'document'.
     */
    public function document(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'document',
        ]);
    }

    /**
     * Indicate that the category is of type 'condition'.
     */
    public function condition(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'condition',
        ]);
    }
}
