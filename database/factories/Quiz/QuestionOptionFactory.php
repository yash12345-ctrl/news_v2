<?php

namespace Database\Factories\Quiz;

use App\Models\Quiz\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelQuizQuestionOption>
 */
class QuestionOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'answer_option' => $this->faker->word, // or use `word` for a single word
            'is_ans_fillable' => $this->faker->numberBetween(0, 1), // Random boolean value
            'question_id' => Question::inRandomOrder()->first()->id, // Random question ID
        ];
    }
}
