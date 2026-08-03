<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            "name_ur" => $this->faker->word(),
            "name_en" => $this->faker->word(),
            "description_ur" => $this->faker->sentence,
            "description_en" => $this->faker->sentence,
        ];
    }
}
