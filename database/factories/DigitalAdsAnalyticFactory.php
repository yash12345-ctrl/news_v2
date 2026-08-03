<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\DigitalAd;
use App\Models\Advertiser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DigitalAdsAnalyticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'advertiser_id' => Advertiser::factory(),
            'digital_ad_id' => DigitalAd::factory(),
            'user_id' => User::factory(),
            'viewed' => random_int(0, 1),
            'clicked' => random_int(0, 1),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
