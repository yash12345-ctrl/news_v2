<?php

namespace App\Models\Quiz;

use App\Models\Quiz\Question;
use App\Models\Quiz\QuestionOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    protected $fillable = [
        'written_ans', 'question_option_id', 'question_id', 'created_at', 'updated_at'
    ];

    public function questionOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
