<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertiser>
 */
class AdvertiserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => random_int(9330000000, 9999999999),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$m10VlTg6o2yYt3SRW92AZOJBIoPNmAWP2/x7nuzt17rgqVhWWzMbW', // 12345678
            'logo_url' => $this->faker->imageUrl(640, 480, "company", true, "advertiser", $gray = false, "jpg"),
            'company_name' => $this->faker->name(),
            'company_size' => random_int(1, 100),
            'company_type' => random_int(1, 4),
            'admin_id' => Admin::factory(),
        ];
    }
}
