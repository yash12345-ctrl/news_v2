<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedExam extends Model
{
    use HasFactory;

    protected $table = 'submitted_exams';
    const EXAM_SUBMITTED = 1;

    protected $fillable = [
        'user_id', 'exam_id', 'is_submitted', 'created_at', 'updated_at'
    ];
}
