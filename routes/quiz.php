<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Quiz\ExamController;
use App\Http\Controllers\Api\Quiz\QuestionController;
use App\Http\Controllers\Api\Quiz\UserAuthController;
use App\Http\Controllers\Api\Quiz\UserJoiningController;
use App\Http\Controllers\Api\Quiz\UserProfileController;


Route::middleware('auth:sanctum')->group(function() {
	Route::get('/v1/exams', [ExamController::class, 'index']);
	Route::post('/v1/exams', [ExamController::class, 'store']);
	Route::get('/v1/exams/{exam}', [ExamController::class, 'show']);
	Route::patch('/v1/exams/{exam}', [ExamController::class, 'update']);
	Route::patch('/v1/exams/{exam}/update-status', [ExamController::class, 'updateStatus']);
	Route::post('/v1/exams/{exam}/upload', [ExamController::class, 'upload']);
	Route::get('/v1/exams/{exam}/scoreboard', [ExamController::class, 'scoreboard']);
	Route::get('/v1/exams/{exam}/my-standing', [ExamController::class, 'myStanding']);
	Route::get('/v1/exams/{exam}/questions', [ExamController::class, 'questions']);
	Route::get('/v1/exams/{exam}/top-players', [ExamController::class, 'topPlayers']);
	Route::get('/v1/exams/{exam}/user-results/{user}', [ExamController::class, 'userResults']);

	// Question APIs
	Route::post('/v1/questions', [QuestionController::class, 'store']);
	Route::get('/v1/questions/{question}', [QuestionController::class, 'show']);
	Route::patch('/v1/questions/{question}', [QuestionController::class, 'update']);
	Route::delete('/v1/questions/{question}', [QuestionController::class, 'destroy']);
	Route::get('/v1/questions/{question}/results', [QuestionController::class, 'questionResult']);
	Route::patch('/v1/questions/{question}/question-medias', [QuestionController::class, 'uploadQuestionMedia']);
	Route::delete('/v1/questions/{question}/question-medias', [QuestionController::class, 'deleteQuestionMedia']);
	Route::post('/v1/questions/{question}/user-answer', [QuestionController::class, 'userAnswer']);

	Route::get('/v1/exams/questions/download-sample', [QuestionController::class, 'downloadSampleQuestion']);
	Route::post('/v1/exams/{exam}/questions/upload', [QuestionController::class, 'uploadExamQuestion']);
	Route::get('/v1/exams/{exam}/questions/download', [QuestionController::class, 'downloadExamQuestion']);

	Route::post('/v1/users/user-joining/join', [UserJoiningController::class, 'join']);
	Route::post('/v1/auth/users/logout', [UserAuthController::class, 'logout']);

	Route::get('/v1/avatars', [UserProfileController::class, 'avatars']);
	Route::post('/v1/users/upload-profile-image', [UserProfileController::class, 'uploadProfileImage']);
});

Route::post('/v1/auth/users/register', [UserAuthController::class, 'registerPlayer']);
Route::get('/v1/exams/{exam}/download-result', [ExamController::class, 'downloadResult']);

Route::get('/v1/exams/pin/{pin}', [ExamController::class, 'findByPin']);
