<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Search;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'headline' => fake()->word,
            'web_url' => fake()->text(),
            'pub_date' => fake()->dateTime,
            'source_id' => Source::factory(), // make Source and assign the id
            'category_id' => Category::factory(), // make Category and assign the id
            'search_id' => Search::factory(), // make Category and assign the id
        ];
    }
}
