<?php

namespace Database\Factories\Quiz;

use App\Models\Quiz\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelQuizQuestion>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence,
            'point' => 2,
            'question_number' => random_int(1, 100),
            'question_time' => random_int(1, 20),
            'image_url' => 'https://placehold.co/600x400?text=Quiz%20Exam',
            'exam_id' => Exam::inRandomOrder()->first()->id,
        ];
    }
}
