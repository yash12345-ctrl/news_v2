<?php

namespace App\Models\Quiz;

use App\Models\User;
use App\Models\Quiz\Exam;
use App\Models\Quiz\Answer;
use App\Models\Quiz\Question;
use App\Models\Quiz\QuestionOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAnswer extends Model
{
    use HasFactory;

    protected $table = 'user_answers';

    protected $fillable = [
        'written_ans', 'user_id', 'exam_id', 'question_id', 'question_option_id', 'is_correct', 'created_at', 'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function questionOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class);
    }

    public static function userAnswerKeyedWithQuestionId($user_id)
    {
        $result = array();

        $user_answers = static::where('user_id', $user_id)->get();

        foreach ($user_answers as $answer) {
            $result[$answer->question_id] = $answer;
        }

        return $result;
    }

    public static function checkAnswer($question_id, $question_option_id)
    {
        $answer = Answer::where('question_id', $question_id)->first();
        return $answer->question_option_id === (int) $question_option_id ? 1 : 0;
    }

    public static function UserSubmittedQuestion($user_id, $exam_id, $question_id)
    {
        return self::where('user_id', '=', $user_id)
                    ->where('exam_id', '=', $exam_id)
                    ->where('question_id', '=', $question_id);
    }

}
