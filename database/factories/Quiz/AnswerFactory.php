<?php

namespace Database\Factories\Quiz;

use App\Models\Quiz\QuestionOption;
use App\Models\Quiz\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelQuizAnswer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'written_ans' => $this->faker->optional()->sentence, // Optional written answer
            'question_option_id' => QuestionOption::inRandomOrder()->first()->id,
            'question_id' => Question::inRandomOrder()->first()->id,
        ];
    }
}
