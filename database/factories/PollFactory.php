<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poll>
 */
class PollFactory extends Factory
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
            "description"   => $this->faker->paragraph,
            "question"      => $this->faker->sentence,
            "media_url"     => $this->faker->url,
            "media_kind"    => $this->faker->numberBetween(1, 2),
            "status"        => $this->faker->numberBetween(1, 2),
            "published_at"  => $this->faker->dateTime(),
        ];
    }
}
