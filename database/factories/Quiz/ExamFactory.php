<?php

namespace Database\Factories\Quiz;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelQuizExam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'score' => $this->faker->numberBetween(1, 2),
            'exam_pin' => $this->faker->numberBetween(100000, 999999),
            'negative_score' => 0,
            'total_ques' => 50,
            'status' => random_int(1, 2),
        ];
    }
}
