<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Screening>
 */
class ScreeningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'starts_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'available_seats' => $this->faker->numberBetween(1, 100),
            'movie_id' => Movie::factory(),
        ];
    }
}
