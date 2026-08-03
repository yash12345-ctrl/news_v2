<?php

namespace Database\Factories;

use App\Models\Advertiser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DigitalAd>
 */
class DigitalAdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "uuid" => $this->faker->uuid(),
            "title" => $this->faker->realTextBetween(64, 100),
            "description" => $this->faker->realTextBetween(200, 1024),
            "cta_url" => $this->faker->url(),
            "cta_text" => $this->faker->realTextBetween(10, 20),
            "media_url" => $this->faker->imageurl(),
            "media_kind" => random_int(1, 2),
            "ad_kind" => random_int(1, 2),
            "ad_url" => $this->faker->url(),
            "advertiser_id" => Advertiser::factory(),
            "price" => random_int(500, 4000),
            "status" => random_int(1, 5),
            "expires_at" => $this->faker->dateTime(),
        ];
    }
}
