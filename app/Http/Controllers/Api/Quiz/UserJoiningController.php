<?php

namespace App\Http\Controllers\Api\Quiz;

use App\Models\Quiz\Exam;
use Illuminate\Http\Request;
use App\Models\Quiz\ExamResult;
use App\Http\Controllers\Controller;
use App\Models\Quiz\UserAssignedExam;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserAssignedExamResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserJoiningController extends Controller
{
    public function join(Request $request): JsonResource
    {
        $user = auth()->user();
        if (!$user->isUser()) {
            throw new HttpException(403, 'You are not allow to participate in exam');
        }

        $validated = $request->validate([
            "exam_pin" => "required|numeric|exists:exams,exam_pin"
        ]);

        $exam = Exam::findByPin($validated['exam_pin'])->first();

        if (is_null($exam)) {
            throw ValidationException::withMessages([
                "exam_pin" => ["Invalid exam code."]
            ]);
        }

        if (!$exam->isExamPublished()) {
            throw new HttpException(403, "You cannot join the quiz because the exam has not been published yet");
        }

        $user_assigned_exam = UserAssignedExam::create([
            "exam_id"   => $exam->id,
            "user_id"   => $user->id,
        ]);

        ExamResult::create([
            "user_id" => $user->id,
            "exam_id" => $exam->id,
            "score" => 0,
        ]);

        return new UserAssignedExamResource($user_assigned_exam);
    }
}
