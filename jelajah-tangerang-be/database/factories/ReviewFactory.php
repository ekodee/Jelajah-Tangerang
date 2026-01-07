<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            // User diambil random di Seeder nanti
            'user_id'        => User::factory(),
            // Destination/Article diisi null dulu, nanti di-override di Seeder
            'destination_id' => null,
            'article_id'     => null,
            'rating'         => $this->faker->numberBetween(3, 5), // Rating 3-5 biar bagus
            'comment'        => $this->faker->sentence(rand(6, 12)), // Komentar 6-12 kata
        ];
    }
}
