<?php

namespace Database\Factories;

use App\Models\Color;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class FavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'color_id' => Color::factory(),
            'user_id' => User::factory(),
            'name' => fake()->word(),
        ];
    }
}
