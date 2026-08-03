<?php

namespace App\Models\Quiz;

use App\Models\Quiz\Question;
use App\Models\Quiz\ExamResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_RUNNING = 3;
    const STATUS_ENDED = 4;
    const STATUS_CANCEL = 5;

    protected $fillable = [
        'name', 'score', 'exam_pin', 'negative_score', 'total_ques', 'status', 'published_at', 'starts_at', 'image_url', 'created_at', 'updated_at'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function examResults(): HasMany
    {
        return $this->hasMany(ExamResult::class);
    }

    public function isExamEnded()
    {
        return (int) $this->status == self::STATUS_ENDED;
    }

    public function isExamDraft()
    {
        return (int) $this->status == self::STATUS_DRAFT;
    }

    public function isExamPublished()
    {
        return (int) $this->status == self::STATUS_PUBLISHED;
    }

    public function hasExamStarted()
    {
        return (int) $this->status == self::STATUS_RUNNING;
    }

    public static function findByPin($exam_pin)
    {
        return self::where('exam_pin', '=', $exam_pin);
    }
}
