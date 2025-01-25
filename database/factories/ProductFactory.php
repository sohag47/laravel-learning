<?php

namespace Database\Factories;

use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'image' => fake()->imageUrl(),
            'description' => fake()->sentence(),
            'sku' => null,
            'price' => fake()->numberBetween(100, 1000),
            'discount_price' => fake()->numberBetween(0, 100),
            'stock' => fake()->numberBetween(0, 100),
            'category_id' => null,
            'brand' => null,
            'gallery' => null,
            'status' => fake()->randomElement(CategoryStatus::cases())->value,
        ];
    }
}
