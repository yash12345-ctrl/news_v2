<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ENewsPaper>
 */
class ENewsPaperFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title"         => $this->faker->sentence,
            "subtitle"      => $this->faker->sentence,
            "description"   => $this->faker->paragraph,
            "slug"          => $this->faker->slug,
            "image_url"     => $this->faker->imageUrl(400, 400),
            "pages"         => $this->faker->numberBetween(0, 12),
            "edition"   => random_int(1, 5),
            "admin_id"      => 1,
            "status"        => $this->faker->numberBetween(1, 3),
        ];
    }
}
