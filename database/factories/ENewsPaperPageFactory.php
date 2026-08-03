<?php

namespace Database\Factories;

use App\Models\ENewsPaper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ENewsPaperPage>
 */
class ENewsPaperPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_url' => $this->faker->imageUrl(1200, 2400),
            'page_number' => random_int(1, 12),
            'enews_paper_id' => ENewsPaper::factory(),
        ];
    }
}
