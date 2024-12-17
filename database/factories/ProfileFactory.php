<?php

namespace Database\Factories;

use App\Enums\CategoryStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->value('id') ?: User::factory(),
            'username' => fake()->userName(),
            'status' => $this->faker->randomElement(CategoryStatus::cases())->value,
        ];
    }
}
