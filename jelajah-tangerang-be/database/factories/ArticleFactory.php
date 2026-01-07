<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(4, 7));
        return [
            'user_id'      => User::inRandomOrder()->first()->id ?? 1,
            'category_id'  => Category::inRandomOrder()->first()->id ?? 1,
            'title'        => $title,
            'slug'         => Str::slug($title),
            // Bungkus paragraf dengan tag <p>
            'content'      => collect($this->faker->paragraphs(rand(3, 6)))
                ->map(fn($p) => "<p>$p</p>")
                ->implode(''),
            'thumbnail'    => 'https://placehold.co/800x600?text=' . urlencode(substr($title, 0, 15)) . '...',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
