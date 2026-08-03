<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Poll;
use App\Models\User;
use App\Models\Admin;
use App\Models\Article;
use App\Models\PollVote;
use App\Models\DigitalAd;
use App\Models\Quiz\Exam;
use App\Models\Advertiser;
use App\Models\ENewsPaper;
use App\Models\PollAnswer;
use App\Models\ArticleVote;
use App\Models\Quiz\Answer;
use App\Models\Quiz\Question;
use App\Models\ArticleComment;
use App\Models\ENewsPaperPage;
use Illuminate\Database\Seeder;
use App\Models\DigitalAdsAnalytic;
use App\Models\Quiz\QuestionOption;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        ENewsPaper::factory(10)->create();
        User::factory(50)->create();
        Advertiser::factory(20)->create();
        Admin::factory(50)->create();
        DigitalAd::factory(10)->create();
        DigitalAdsAnalytic::factory(10)->create();
        ENewsPaperPage::factory(100)->create();
        $top_cats = collect(['Kolkata', 'Politics', 'Entertainment', 'Sports', 'testdata', 'ab', 'et', 'quasi'])->map(function($name) {
            return \App\Models\Category::factory()->create(['name_en' => $name, 'name_ur' => $name]);
        });
        Article::factory(100)->create()->each(function($article) use ($top_cats) {
            $article->update(['category_id' => $top_cats->random()->id, 'status' => \App\Models\Article::PUBLISHED]);
        });
        ArticleVote::factory(100)->create();
        ArticleComment::factory(50)->create();
        Poll::factory(50)->has(PollAnswer::factory()->count(2))->create();
        PollVote::factory(50)->create();
        Exam::factory(10)->create();
        Question::factory(50)->create()->each(function ($question) {
            // For each question, create 4 options
            $options = QuestionOption::factory()->count(4)->create([
                'question_id' => $question->id,
            ]);

            // Create one answer for the question
            if ($options->count() > 0) {
                $option = $options->random(); // Pick a random option
                Answer::factory()->create([
                    'question_option_id' => $option->id,
                    'question_id' => $question->id,
                ]);
            }
        });
    }
}
