<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Support\Str;
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
        $slug = Str::slug($this->faker->realTextBetween(6, 64)) . random_int(100, 999);
        return [
            'title_en' => $this->faker->realTextBetween(6, 64),
            'title_ur' => $this->faker->realTextBetween(6, 64),
            'content_short_en' => $this->faker->realTextBetween(100, 200),
            'content_short_ur' => $this->faker->realTextBetween(100, 200),
            'content_en' => $this->faker->realTextBetween(200, 1024),
            'content_ur' => $this->faker->realTextBetween(200, 1024),
            'slug' => $slug,
            'image_url' => $this->faker->imageUrl(),
            'source' => $this->faker->realTextBetween(6, 64),
            'article_url' => env('APP_URL') . "/articles/{$slug}",
            'category_id' => Category::factory(),
            'admin_id' => Admin::factory(),
            'views' => random_int(100, 10000),
            'status' => random_int(1, 3),
            'source' => $this->faker->realTextBetween(6, 64),
            'published_at' => $d = now(),
            'created_at' => date("Y-m-d H:i:s", strtotime('-' . random_int(0, 5) . ' days', $d->getTimestamp())), // 0 to 5 days behind publish date
        ];
    }
}
