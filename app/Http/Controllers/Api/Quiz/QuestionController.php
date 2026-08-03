<?php

namespace App\Http\Controllers\Api\Quiz;

use App\Support\CSVFile;
use App\Models\Quiz\Exam;
use App\Models\Quiz\Answer;
use Illuminate\Http\Request;
use App\Models\MediaResource;
use App\Models\Quiz\Question;
use App\Models\Quiz\ExamResult;
use App\Models\Quiz\UserAnswer;
use App\Data\QuestionColumnsList;
use App\Models\Quiz\QuestionOption;
use App\Http\Controllers\Controller;
use App\Models\Quiz\UserAssignedExam;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\UserAnswerResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QuestionController extends Controller
{
    public function store(Request $request): JsonResource
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allow to create questions");
        }

        $validated = $this->validateRequest($request);
        $exam = Exam::find($validated['exam_id']);

        $validated['question_number'] = $exam->total_ques + 1;

        $question = Question::create($validated);

        if (is_null($question)) {
            throw new HttpException(404, "Question is not created.");
        }

        $this->saveQuestionOptions($validated, $question);

        $exam->increment('total_ques');

        return QuestionResource::make(
            $question->load(['questionOptions', 'answer'])
        );
    }

    public function update(Request $request, Question $question): JsonResource
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allow to update questions");
        }

        $validated = $this->validateRequest($request);

        $question->update($validated);

        $this->deleteOptionAndAnswer($question);

        $this->saveQuestionOptions($validated, $question);

        return QuestionResource::make(
            $question->load(['questionOptions', 'answer'])
        );
    }

    public function show(Request $request, Question $question): JsonResource
    {
        $user = auth()->user();

        $relations = ['questionOptions'];
        if ($user->isUser()) {
            $exam = Exam::find($question->exam_id);
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

        return QuestionResource::make(
            $question->load($relations)
        );
    }

    public function destroy(Request $request, Question $question): JsonResource
    {
        $user = auth()->user();

        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allow to delete questions");
        }

        $exam = Exam::find($question->exam_id);

        if ($exam->status == Exam::STATUS_PUBLISHED) {
            throw ValidationException::withMessages([
                "error" => ["Deleting questions of published exams are not allowed."],
            ]);
        }

        $deleted_question_number = $question->question_number;

        $question->delete();

        $questions = Question::where('exam_id', $exam->id)
                              ->where('question_number', '>', $deleted_question_number)
                              ->decrement('question_number');

        $exam->decrement('total_ques');
        return new QuestionResource($question);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            "question"                              => "required",
            "set_number"                            => "required|integer",
            "point"                                 => "required|integer",
            "question_time"                         => "required|integer",
            "exam_id"                               => "required|integer|exists:exams,id",
            "question_options"                      => "required|array|min:2|max:8",
            "question_options.*.answer_option"      => "required",
            "question_option_id"                    => "required|integer",
        ]);
    }

    private function saveQuestionOptions($validated, $question)
    {
        $answer = $validated['question_option_id'];
        $i = 1;

        foreach ($validated['question_options'] as $option) {
            $validated['answer_option'] = $option['answer_option'];
            $validated['question_id']   = $question->id;
            $option = QuestionOption::create($validated);

            // Saving correct answer with otpion id
            if ($answer == $i) {
                $validated['question_option_id'] = $option->id;
                Answer::create($validated);
            }
            $i++;
        }
    }

    private function deleteOptionAndAnswer($question)
    {
        $question_options = $question->questionOptions();
        $answer = $question->answer();
        $question_options->delete();
        $answer->delete();
    }

    public function questionResult(Request $request, Question $question)
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allow to view question result");
        }

        $answer = $question->answer;
        $answer_counts = UserAnswer::where('question_id', $question->id)
                                    ->groupBy('question_option_id')
                                    ->selectRaw('question_option_id, count(*) as count')
                                    ->get();
        return [
            "answer_counts" => $answer_counts->load('questionOption'),
            "answer" => $answer->load('questionOption')
        ];
    }

    public function uploadQuestionMedia(Request $request, Question $question): JsonResource
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allow to upload question media");
        }

        $validated = $request->validate([
            "media"     => "required",
            "media.id"  => "required_with:media|integer",
        ]);

        $id = $validated['media']['id'];
        if (is_null($media_resource = MediaResource::find($id))) {
            throw ValidationException::withMessages([
                "error" => ["Media Resource Not Found"],
            ]);
        }

        $question->media_type = $media_resource->media_type;
        $question->media_url = $media_resource->media_url;

        $question->save();
        $media_resource->delete();

        return new QuestionResource($question->load(['questionOptions', 'answer']));
    }

    public function deleteQuestionMedia(Request $request, Question $question): JsonResource
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allow to delete question media");
        }

        $image_path = public_path('uploads' . $question->media_url);
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $question->media_type = Question::MEDIA_TYPE_TEXT;
        $question->media_url = null;
        $question->updated_at = date('Y-m-d H:i:s');
        $question->save();

        return new QuestionResource($question->load(['questionOptions', 'answer']));
    }

    public function userAnswer(Request $request, Question $question)
    {
        $user = auth()->user();
        if (!$user->isUser()) {
            throw new HttpException(403, "You do not have permission to submit answer");
        }

        $validated = $request->validate([
            "question_option_id"    => "required|integer|exists:question_options,id",
        ]);

        $exam = $question->exam()->first();
        $user_exam = UserAssignedExam::userAssignedExam($user->id, $exam->id)->first();
        if (is_null($user_exam)) {
            throw new HttpException(403, "You can't submit the answer. You are not registered for this exam.");
        }

        if (!$exam->hasExamStarted()) {
            throw new HttpException(403, "You cannot submit answer because the exam has not been started yet");
        }

        $user_answered_question = UserAnswer::UserSubmittedQuestion($user->id, $exam->id, $question->id)->first();
        if (!is_null($user_answered_question)) {
            throw new HttpException(403, "You have already answered this question");
        }

        $correct_answer = UserAnswer::checkAnswer($question->id, $validated['question_option_id']);

        $validated['is_correct'] = $correct_answer;

        $user_answer = UserAnswer::create([
            'user_id' => $user->id,
            'exam_id' => $exam->id,
            'question_id' => $question->id,
            'question_option_id' => $validated['question_option_id'],
            'is_correct' => $correct_answer
        ]);

        $user_exam_result = ExamResult::findResultByExamIdUserId($exam->id, $user->id)->first();

        if ($correct_answer) {
            $user_exam_result->score += $question->point;
            $user_exam_result->ncorrect_question += 1;
        } else {
            $user_exam_result->nincorrect_question += 1;
        }

        $user_exam_result->nattempted_question += 1;
        $user_exam_result->save();
        $data = $user_answer->load(['questionOption', 'question']);
        $data['user_exam_result'] = $user_exam_result;

        return [
            'data' => $data
        ];
    }

    public function downloadSampleQuestion()
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw ValidationException::withMessages([
                "error" => ["You are not allowed to download question sample file"],
            ]);
        }

        $array[] = [
            "question"                  => "",
            "set_number"                => "",
            "point"                     => "",
            "question_time"             => "",
            "option_1"                  => "",
            "option_2"                  => "",
            "option_3"                  => "",
            "option_4"                  => "",
            "option_5"                  => "",
            "option_6"                  => "",
            "option_7"                  => "",
            "option_8"                  => "",
            "correct_option(1,2,3,4,5,6,7,8)"   => "",
        ];

        $csv = new CSVFile($array);

        $csv->fields([
            "question",
            "set_number",
            "point",
            "question_time",
            "option_1",
            "option_2",
            "option_3",
            "option_4",
            "option_5",
            "option_6",
            "option_7",
            "option_8",
            "correct_option(1,2,3,4,5,6,7,8)",
        ])->map(function($l) {
            return [
                $l['question'],
                $l['set_number'],
                $l['point'],
                $l['question_time'],
                $l['option_1'],
                $l['option_2'],
                $l['option_3'],
                $l['option_4'],
                $l['option_5'],
                $l['option_6'],
                $l['option_7'],
                $l['option_8'],
                $l['correct_option(1,2,3,4,5,6,7,8)'],
            ];
        })->download();
    }

    public function uploadExamQuestion(Request $request, Exam $exam)
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw ValidationException::withMessages([
                "error" => ["You are not allowed to upload questions"],
            ]);
        }

        $questions = $exam->questions()->get();
        $total_uploaded  = $exam->questions()->count();

        if ($total_uploaded > 0) {
            throw ValidationException::withMessages([
                "error" => ["Questions already created.  You cannot upload an Excel file after questions are created."],
            ]);
        }

        $request->validate([
            'file' => 'required|mimes:csv'
        ]);

        $name = 'exam_questions_upload.csv';
        if ($file = $request->file('file')) {
            $file->move('uploads', $name);
        }

        $destination = public_path('uploads/'.$name);

        $questions = [];

        if (($handle = fopen($destination, "r")) !== false) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                $questions[] = $data;
            }

            $array = array_shift($questions);
            $required_column_indices = QuestionColumnsList::REQUIRED_COLUMN_INDICES;
            $optional_column_indices = QuestionColumnsList::OPTIONAL_COLUMN_INDICES;

            foreach ($questions as $index => $question) {
                $is_empty = false;
                $row = $index + 2;

                foreach($required_column_indices as $key => $column) {
                    if (is_int($key) && ($question[$key] === '' || $question[$key] === null)) {
                        $is_empty = true;
                        break;
                    }
                }

                if ($is_empty) {
                    continue;
                }

                $total_option = 0;
                $first_index  = $optional_column_indices['option_1'];
                $last_index   = $optional_column_indices['option_8'];
                for ($i = $first_index; $i <= $last_index; ++$i) {
                    if (!empty($question[$i])) {
                        $total_option += 1;
                        if ($total_option != $i - $first_index + 1) {
                            throw ValidationException::withMessages([
                                'error' => ["Row {$row}: Leaving empty option between two options is not allowed, should be contiguous."],
                            ]);
                        }
                    }
                }

                if ($total_option < $question[$required_column_indices['correct_option']]) {
                    throw ValidationException::withMessages([
                        'error' => ["Row {$row}: correct option is wrong."],
                    ]);
                }

                $question_request = $request->merge([
                    'question'        => $question[$required_column_indices['question']],
                    'set_number'      => $question[$required_column_indices['set_number']],
                    'point'           => $question[$required_column_indices['point']],
                    'question_time'   => $question[$required_column_indices['question_time']],
                    'option_1'        => $question[$optional_column_indices['option_1']],
                    'option_2'        => $question[$optional_column_indices['option_2']],
                    'option_3'        => $question[$optional_column_indices['option_3']],
                    'option_4'        => $question[$optional_column_indices['option_4']],
                    'option_5'        => $question[$optional_column_indices['option_5']],
                    'option_6'        => $question[$optional_column_indices['option_6']],
                    'option_7'        => $question[$optional_column_indices['option_7']],
                    'option_8'        => $question[$optional_column_indices['option_8']],
                    'correct_option'  => $question[$required_column_indices['correct_option']],
                ]);

                $question_validated[$index] = $question_request->validate([
                    'question'          => 'required',
                    'set_number'        => 'required|integer',
                    'point'             => 'required|integer',
                    'question_time'     => 'required|integer',
                    'option_1'          => 'required',
                    'option_2'          => 'required',
                    'option_3'          => 'nullable',
                    'option_4'          => 'nullable',
                    'option_5'          => 'nullable',
                    'option_6'          => 'nullable',
                    'option_7'          => 'nullable',
                    'option_8'          => 'nullable',
                    'correct_option'    => 'required|integer|in:1,2,3,4,5,6,7,8',
                ]);
            }

            foreach ($question_validated as $key => $q) {
                $question_count = $exam->questions()->count();
                $q['exam_id'] = $exam->id;
                $q['question_number'] = $question_count + 1;
                $question = Question::create($q);

                $options = [];
                for ($i = 1; $i <= 8; $i++) {
                    $option_key = 'option_' . $i;
                    if (!empty($q[$option_key])) {
                        $options[] = ['answer_option' => $q[$option_key]];
                    }
                }

                $validated = [
                    'question_options' => $options,
                    'question_option_id' => $q['correct_option'],
                ];

                $this->saveQuestionOptions($validated, $question);
            }
            $exam->total_ques = count($question_validated);
            $exam->save();

            fclose($handle);
        }
    }

    public function downloadExamQuestion(Request $request, Exam $exam)
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw ValidationException::withMessages([
                "error" => ["You are not allowed to download questions"],
            ]);
        }

        $questions = $exam->questions()->with(['questionOptions', 'answer'])->get()->toArray();
        $csv = new CSVFile($questions);

        $csv->fields([
            "question", "set_number", "point", "question_number", "question_time", "media_type", "media_url", "option_1", "option_2", "option_3", "option_4", "option_5", "option_6", "option_7", "option_8", "correct_option(1,2,3,4,5,6,7,8)",
        ])->map(function($l) {
            $correct_option_index = 0;

            foreach ($l['question_options'] as $index => $option) {
                if ($option['id'] === $l['answer']['question_option_id']) {
                    $correct_option_index = $index + 1;
                    break;
                }
            }
            return [
                $l['question'],
                $l['set_number'],
                $l['point'],
                $l['question_number'],
                $l['question_time'],
                $l['media_type'],
                $l['media_url'],
                isset($l['question_options'][0]) ? $l['question_options'][0]['answer_option'] : '',
                isset($l['question_options'][1]) ? $l['question_options'][1]['answer_option'] : '',
                isset($l['question_options'][2]) ? $l['question_options'][2]['answer_option'] : '',
                isset($l['question_options'][3]) ? $l['question_options'][3]['answer_option'] : '',
                isset($l['question_options'][4]) ? $l['question_options'][4]['answer_option'] : '',
                isset($l['question_options'][5]) ? $l['question_options'][5]['answer_option'] : '',
                isset($l['question_options'][6]) ? $l['question_options'][6]['answer_option'] : '',
                isset($l['question_options'][7]) ? $l['question_options'][7]['answer_option'] : '',
                $correct_option_index,
            ];
        })->download();
    }
}
