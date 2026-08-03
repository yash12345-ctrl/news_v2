<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAssignedExam extends Model
{
    use HasFactory;
    protected $table = 'user_assigned_exams';

    protected $fillable = [
        'user_id', 'exam_id', 'created_at', 'updated_at'
    ];

    public static function userAssignedExam($user_id, $exam_id) {
        return self::where('user_id', '=', $user_id)
                ->where('exam_id', '=', $exam_id);
    }
}
