<?php

namespace App\Models\Quiz;

use App\Models\Quiz\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionOption extends Model
{
    use HasFactory;

    protected $table = 'question_options';

    protected $fillable = [
        'answer_option', 'is_ans_fillable', 'question_id', 'created_at', 'updated_at'
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
