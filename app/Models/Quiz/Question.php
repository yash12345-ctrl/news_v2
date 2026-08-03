<?php

namespace App\Models\Quiz;

use App\Models\Quiz\Exam;
use App\Models\Quiz\Answer;
use App\Models\Quiz\UserAnswer;
use App\Models\Quiz\QuestionOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';
    const MEDIA_TYPE_TEXT = 1;
    const MEDIA_TYPE_IMAGE = 2;
    const MEDIA_TYPE_AUDIO = 3;
    const MEDIA_TYPE_VIDEO = 4;

    protected $fillable = [
        'question', 'set_number', 'point', 'question_number', 'question_time', 'media_type', 'media_url', 'image_url', 'exam_id', 'created_at', 'updated_at'
    ];

    public function questionOptions(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function answer(): HasOne
    {
        return $this->hasOne(Answer::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    public static function getQuestionsByExamIdAndUserId(int $exam_id, int $user_id)
    {
        $questions = self::where('exam_id', $exam_id)->get();

        if (! $questions) {
            return null;
        }
        $qInstance = array();
        $user_answers = UserAnswer::userAnswerKeyedWithQuestionId($user_id);

        foreach ($questions as $question) {
            if (!isset($user_answers[ $question->id ])) {
                // @NOTE: Skip the question from question which are not attempted/answered by User
                continue;
            }

            $correct_option_id = $question->answer()->first()->question_option_id;
            $q = new \stdClass;
            $q->id = $question->id;
            $q->question = $question->question;
            $q->set_number = $question->set_number;
            $q->point = $question->point;
            $q->question_number = $question->question_number;
            $q->question_time = $question->question_time;
            $q->media_type = $question->media_type;
            $q->media_url = $question->media_url;
            $q->exam_id = $question->exam_id;
            $q->created_at = $question->created_at;
            $q->updated_at = $question->updated_at;

            $q->options = $question->questionOptions()->get();

            $q->correct_ans_option_id = $correct_option_id;
            $q->correct_ans = QuestionOption::find($correct_option_id)->answer_option;
            $q->user_ans_option_id = $user_answers[ $question->id ]->question_option_id;

            if ($q->user_ans_option_id) {
                $q->user_ans = QuestionOption::find($q->user_ans_option_id)->answer_option;
            }

            $qInstance[] = $q;
        }

        return $qInstance;
    }
}
