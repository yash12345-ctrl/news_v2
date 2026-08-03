<?php

namespace App\Models\Quiz;

use App\Models\User;
use App\Models\Quiz\Exam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamResult extends Model
{
    use HasFactory;

    protected $table = 'exam_results';

    const ATTENDANCE_PRESENT = 1;
    const ATTENDANCE_ABSENT = 2;
    const RESULT_PUBLISHED = 1;

    protected $fillable = [
        'exam_id', 'user_id', 'score', 'user_rank', 'nattempted_question', 'total_negative_marks', 'total_correct_marks', 'ncorrect_question', 'nincorrect_question', 'is_published', 'created_at', 'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public static function findResultByExamIdUserId($exam_id, $user_id)
    {
        return self::where('exam_id', '=', $exam_id)
                    ->where('user_id', '=', $user_id);
    }
}
