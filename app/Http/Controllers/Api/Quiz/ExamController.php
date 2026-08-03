<?php

namespace App\Http\Controllers\Api\Quiz;

use App\Models\User;
use App\Support\CSVFile;
use App\Models\Quiz\Exam;
use Illuminate\Http\Request;
use App\Models\Quiz\Question;
use App\Models\Quiz\ExamResult;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Quiz\UserAssignedExam;
use App\Support\ControllerHelperTrait;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\ExamResultResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExamController extends Controller
{
    use ControllerHelperTrait;

    public function index(Request $request): JsonResource
    {
        $exam = Exam::query();

        if ($v = request("from_date")) {
            $exam->whereDate("created_at", ">=", date("Y-m-d", strtotime($v)));
        }

        if ($v = request("to_date")) {
            $exam->whereDate("created_at", "<=", date("Y-m-d", strtotime($v)));
        }

        if (request("upcoming")) {
            $exam->whereDate("starts_at", ">", date("Y-m-d"));
        }

        if ($v = request("status")) {
            $exam->where("status", "=", (int) $v);
        }

        if ($v = request("q")) {
            $exam->where(function($query) use($v) {
                $query->where('id', '=', $v);
                $query->orWhere('name', 'LIKE', "%{$v}%");
            });
        }

        $exam = $exam->orderBy('id', 'DESC')->paginate(20);

        return ExamResource::collection($exam);
    }

    public function store(Request $request): JsonResource
    {
        $user = auth()->user();

        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allow to create exam");
        }

        $validated = $request->validate([
            "name"                          => "required|max:256",
            "score"                         => "required|integer|min:0",
            "negative_score"                => "nullable|integer|min:0",
        ]);

        $validated['exam_pin'] = str_pad(strval(random_int(1, 999999)), 6, '0', STR_PAD_LEFT);
        $validated['status'] = $validated['status'] ?? 1;
        $validated['total_ques'] = $validated['total_ques'] ?? 0;
        $validated['published_at'] = $validated['published_at'] ?? null;
        $validated['starts_at'] = $validated['starts_at'] ?? null;
        $validated['image_url'] = env('DEFAULT_IMG_URL');

        $exam = Exam::create($validated);

        return new ExamResource($exam);
    }

    public function update(Request $request, Exam $exam): JsonResource
    {
        $user = auth()->user();

        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allow to update exam");
        }

        $validated = $request->validate([
            "name"                          => "required|max:256",
            "score"                         => "required|integer|min:0",
            "negative_score"                => "nullable|integer|min:0",
        ]);

        $exam->update($validated);

        return new ExamResource($exam);
    }

    public function show(Request $request, Exam $exam): JsonResource
    {
        return new ExamResource($exam);
    }

    public function upload(Request $request, Exam $exam): JsonResource
    {
        $exam = $this->_uploadImage($request, $exam, "photo");

        return new ExamResource($exam);
    }

    public function updateStatus(Request $request, Exam $exam): JsonResource
    {
        $validated = $request->validate([
            'status' => 'required|integer|in:2,3,4,5'
        ]);

        if ($validated['status'] == Exam::STATUS_PUBLISHED) {
            $validated['published_at'] = date('Y-m-d H:i:s');
        }

        $exam->update($validated);

        return new ExamResource($exam);
    }

    public function questions(Request $request, Exam $exam): JsonResource
    {
        $user = auth()->user();
        $relations = ['questionOptions'];

        if ($user->isUser()) {
            $user_exam = UserAssignedExam::userAssignedExam($user->id, $exam->id)->first();
            if (is_null($user_exam)) {
                throw new HttpException(403, "You can't view the questions. You are not registered for this exam.");
            }

            if ($exam->isExamEnded()) {
                $relations[] = 'answer';
            }
        }

        if ($user->isSuperAdmin()) {
            $relations[] = 'answer';
        }

        $questions = $exam->questions()->with($relations)->orderBy('question_number', 'ASC')->get();
        return QuestionResource::collection($questions);
    }

    public function scoreboard(Request $request, Exam $exam): JsonResource
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allowed to view scoreboard.");
        }

        $scoreboards = ExamResult::where('exam_id', $exam->id)
            ->with('user')
            ->orderBy('score', 'desc')
            ->orderBy('id', 'asc')
            ->paginate(50);

        return ExamResultResource::collection($scoreboards);
    }

    public function myStanding(Request $request, Exam $exam)
    {
        $user = auth()->user();
        if (!$user->isUser()) {
            throw new HttpException(403, "You are not allowed to view position of user.");
        }

        $user_exam = UserAssignedExam::userAssignedExam($user->id, $exam->id)->first();
        if (is_null($user_exam)) {
            throw new HttpException(403, "You can't see your position. You are not registered for this exam.");
        }

        $scoreboards = ExamResult::where('exam_id', $exam->id)->with('user')
            ->orderBy('score', 'desc')
            ->get();
        $position = 0;
        $user_exam_result = null;

        foreach ($scoreboards as $index => $scoreboard) {
            $position = $index + 1;
            
            if ($scoreboard->user_id == $user->id) {
                $user_position = $position;
                $user_exam_result = $scoreboard;
                break;
            }
        }

        return [
            'data' => [
                'scoreboards' => $scoreboards,
                'position' => $user_position,
                'user_exam_result'=> $user_exam_result
            ]
        ];
    }

    public function userResults(Request $request, Exam $exam, User $user)
    {
        $questions = Question::getQuestionsByExamIdAndUserId($exam->id, $user->id);

        $result = ExamResult::findResultByExamIdUserId($exam->id, $user->id)->first();

        return [
            'data' => [
                "questions" => $questions,
                "result" => $result,
            ]
        ];
    }

    public function topPlayers(Request $request, Exam $exam)
    {
        $user = auth()->user();
        $player = 3;
        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allowed to view top players.");
        }

        if ($v = (int) request("player")) {
            if ($v > 0 && $v <= 20) {
                $player = $v;
            }
        }

        $top_players = ExamResult::where('exam_id', $exam->id)
            ->with('user')
            ->orderBy('score', 'desc')
            ->orderBy('id', 'asc')
            ->take($player)
            ->get();

        return ExamResultResource::collection($top_players);
    }

    public function downloadResult(Request $request, Exam $exam)
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw new HttpException(404, "You are not allowed to download exam result.");
        }

        $exam_results = $exam->examResults()->with('user')->get()->toArray();

        $csv    = new CSVFile($exam_results);
        $csv->fields([
            'user_id',
            'user_name',
            'score',
            'total_question_attempted',
            'total_correct_question',
            'total_incorrect_question',
            'created_at',
        ])->map(function($result) {
            return [
                $result['user_id'],
                $result['user']['first_name'],
                $result['score'],
                $result['nattempted_question'],
                $result['ncorrect_question'],
                $result['nincorrect_question'],
                date('Y-m-d', strtotime($result['created_at'])),
            ];
        })->download();
    }

    public function findByPin(Request $equest, int $pin): JsonResource
    {
        $exam = Exam::findByPin($pin)->first();
        if (is_null($exam)) {
            throw ValidationException::withMessages([
                "exam_pin" => ["Invalid exam code."]
            ]);
        }

        if (!$exam->isExamPublished()) {
            throw new HttpException(403, "You cannot join the quiz because the exam has not been published yet");
        }

        return new ExamResource($exam);
    }
}