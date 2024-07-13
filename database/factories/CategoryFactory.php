<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;
use App\Models\Category;

// use Faker\Generator as Faker;

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
        $title = $this->faker->text(10);
        $slug = Str::slug($title, '-', '{random}'); // Generate unique slug

        //$category = Category::all()->random(); // Pick a random category

        return [
            'title' => $title,
            'slug' => $slug,
        ];
    }
}
