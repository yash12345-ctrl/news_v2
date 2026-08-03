<?php

namespace App\Http\Controllers\Api\Quiz;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Quiz\ExamResult;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Quiz\UserAssignedExam;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserAuthController extends Controller
{
    public function registerPlayer(Request $request)
    {
        $validated = $request->validate([
            "first_name"    => "required|max:32|regex:/^[A-Za-z0-9]+$/",
            "exam_id" => "required|integer|exists:exams,id",
        ]);

        $exam_id = $validated['exam_id'];

        $user_ids = UserAssignedExam::where('exam_id', $exam_id)->pluck('user_id')->toArray();
        $user_exist = User::whereIn('id', $user_ids)
                          ->where('first_name', $validated['first_name'])
                          ->exists();
        if ($user_exist) {
            throw ValidationException::withMessages([
                "first_name" => ["Username is taken. Please try a different username."]
            ]);
        }

        $validated['photo'] = $this->generateProfileImage();

        $user = User::create($validated);
        $token = $user->createToken('user-token');

        $user_assigned_exam = UserAssignedExam::create([
            "exam_id"   => $exam_id,
            "user_id"   => $user->id,
        ]);

        ExamResult::create([
            "user_id" => $user->id,
            "exam_id" => $exam_id,
            "score" => 0,
        ]);

        return [
            "user" => $user,
            "token" => [
                "token" => $token->plainTextToken,
            ],
        ];
    }

    private function makeAvatar($username)
    {
        $username_hash = md5($username);
        return "https://www.gravatar.com/avatar/{$username_hash}?s=124&r=pg&d=identicon";
    }

    private function generateProfileImage()
    {
        $path = public_path('assets/profile-images/animal-avatar');
        $files = File::files($path);

        if (empty($files)) {
            return env('APP_URL') . '/assets/img/default-image.jpg';
        }

        $randomFile = $files[array_rand($files)];
        $filename = basename($randomFile);

        return env('APP_URL') . '/assets/profile-images/animal-avatar/' . $filename;
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        Auth::guard('user-api')->logout();
        $user->tokens()->delete();
    }
}
