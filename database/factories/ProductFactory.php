<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = fake()->name();
        return [
            'category_id' => rand(1, 10),
            'brand_id' => rand(1, 10),
            'title' => $title,
            'slug' => Str::slug($title),
            'short_desc' => fake()->text(),
            'price' => rand(100, 1000),
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTW1yhlTpkCnujnhzP-xioiy9RdDQkKLMnMSg&s',
            'star' => rand(1, 5),
            'remarks' => fake()->randomElement(['popular', 'featured', 'new', 'bestseller', 'trending']),
        ];
    }
}
