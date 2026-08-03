<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Promotion\PromotionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PollController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\EditionController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HomePageController;
use App\Http\Controllers\Api\PollVoteController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DigitalAdController;
use App\Http\Controllers\Api\GuldastahController;
use App\Http\Controllers\Api\MyProfileController;
use App\Http\Controllers\Api\AdvertiserController;
use App\Http\Controllers\Api\ENewsPaperController;
use App\Http\Controllers\Api\ArticleVoteController;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\VisitorAnalyticController;
use App\Http\Controllers\Api\VisitorStatsController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\GuldastahPageController;
use App\Http\Controllers\Api\MediaResourceController;
use App\Http\Controllers\Api\ArticleCommentController;
use App\Http\Controllers\Api\ENewsPaperPageController;
use App\Http\Controllers\Api\VisitorsSummaryController;
use App\Http\Controllers\Api\DigitalAdsStatsController;
use App\Http\Controllers\Api\DigitalAdsAnalyticController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::middleware('auth:sanctum')->group(function() {

    Route::post('/enews', [ENewsPaperController::class, 'store']);
    Route::post('/enews/{id}', [ENewsPaperController::class, 'update']);
    Route::post('/enews-paper/{id}/uploads', [ENewsPaperPageController::class, 'upload']);
    Route::post('/enews/{id}/upload', [ENewsPaperController::class, 'upload']);
    Route::post('/enews/{id}/status', [ENewsPaperController::class, 'statusUpdate']);

    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/categories/{id}', [CategoryController::class, 'update']);
    Route::post('/categories/{id}/upload', [CategoryController::class, 'upload']);

    Route::post('/articles/translate-text', [ArticleController::class, 'translateText']);
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::post('/articles/{id}', [ArticleController::class, 'update']);
    Route::post('/articles/{id}/status', [ArticleController::class, 'statusUpdate']);
    Route::post('/articles/{id}/upload', [ArticleController::class, 'upload']);
    Route::post('/articles/{id}/flag', [ArticleController::class, 'flag']);
    Route::post('/articles/{id}/remove-flag', [ArticleController::class, 'removeFlag']);
    Route::post('/articles/{id}/add-flag', [ArticleController::class, 'addFlag']);

    Route::post('/comments', [ArticleCommentController::class, 'store']);
    Route::delete('/comments/{id}', [ArticleCommentController::class, 'destroy']);
    Route::post('/comments/{id}', [ArticleCommentController::class, 'update']);

    Route::post('/articles/{id}/votes', [ArticleVoteController::class, 'store']);
    Route::get('/articles/{id}/votes', [ArticleVoteController::class, 'voteStats']);

    Route::post('/advertisers', [AdvertiserController::class, 'store']);
    Route::post('/advertisers/{id}', [AdvertiserController::class, 'update']);
    Route::patch('/advertisers/{id}/status', [AdvertiserController::class, 'updateStatus']);
    Route::post('/advertisers/{id}/upload', [AdvertiserController::class, 'upload']);
    Route::get('/advertisers', [AdvertiserController::class, 'index']);
    Route::get('/advertisers/{id}', [AdvertiserController::class, 'show']);

    Route::post('/admins', [AdminController::class, 'store']);
    Route::get('/admins', [AdminController::class, 'index']);
    Route::get('/admins/profile', [AdminController::class, 'profile']);
    Route::patch('/admins/profile', [AdminController::class, 'updateProfile']);
    Route::patch('/admins/password', [AdminController::class, 'updatePassword']);
    Route::get('/admins/{id}', [AdminController::class, 'show']);
    Route::post('/admins/{id}', [AdminController::class, 'update']);
    Route::post('/admins/{id}/upload', [AdminController::class, 'upload']);
    Route::patch('/admins/{admin}/reset-password', [AdminController::class, 'resetPassword']);
    Route::patch('/admins/{admin}/status', [AdminController::class, 'updateStatus']);
    Route::post('/users', [AuthController::class, 'register']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users/{id}', [UserController::class, 'update']);
    Route::post('/users/{id}/upload', [UserController::class, 'upload']);
    Route::delete('/my-profile/delete', [MyProfileController::class, 'delete']);
    Route::patch('/users/{user}/reset-password', [UserController::class, 'resetPassword']);
    Route::patch('/users/{user}/status', [UserController::class, 'updateStatus']);

    Route::post('/advertisements', [DigitalAdController::class, 'store']);
    Route::post('/advertisements/{id}', [DigitalAdController::class, 'update']);
    Route::post('/advertisements/{id}/upload', [DigitalAdController::class, 'upload']);
    Route::get('/advertisements/{id}', [DigitalAdController::class, 'show']);
    Route::post('/advertisements/{id}/status', [DigitalAdController::class, 'updateStatus']);
    Route::post('/advertisements/{id}/status/resume', [DigitalAdController::class, 'resume']);
    Route::get('/advertisements/{id}/stats', [DigitalAdController::class, 'stats']);

    Route::post('/polls', [PollController::class, 'store']);
    Route::get('/polls', [PollController::class, 'index']);
    Route::post('/polls/{id}/upload', [PollController::class, 'upload']);
    Route::post('/polls/{id}', [PollController::class, 'update']);
    Route::get('/polls/{id}', [PollController::class, 'show']);
    Route::patch('/polls/{id}/status', [PollController::class, 'updateStatus']);

    Route::post('/polls/{id}/votes', [PollVoteController::class, 'store']);
    Route::post('/digital-ads', [DigitalAdsAnalyticController::class, 'store']);

    Route::post('/guldastahs', [GuldastahController::class, 'store']);
    Route::post('/guldastahs/{id}', [GuldastahController::class, 'update']);
    Route::post('/guldastah-paper/{id}/uploads', [GuldastahPageController::class, 'upload']);
    Route::post('/guldastahs/{id}/status', [GuldastahController::class, 'statusUpdate']);

    Route::post('/trending-videos', [\App\Http\Controllers\Api\TrendingVideoController::class, 'store']);
    Route::post('/trending-videos/upload', [\App\Http\Controllers\Api\TrendingVideoController::class, 'upload']);
    Route::post('/trending-videos/{id}', [\App\Http\Controllers\Api\TrendingVideoController::class, 'update']);
    Route::post('/trending-videos/{id}/upload', [\App\Http\Controllers\Api\TrendingVideoController::class, 'upload']);
    Route::post('/trending-videos/{id}/status', [\App\Http\Controllers\Api\TrendingVideoController::class, 'updateStatus']);
    Route::delete('/trending-videos/{id}', [\App\Http\Controllers\Api\TrendingVideoController::class, 'destroy']);
    Route::get('/trending-videos', [\App\Http\Controllers\Api\TrendingVideoController::class, 'index']);

    Route::get('/stats', [DashboardController::class, 'index']);

    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/v1/upload-media', [MediaResourceController::class, 'store']);

    Route::get('/v1/promotions', [PromotionController::class, 'index']);
    Route::post('/v1/promotions', [PromotionController::class, 'store']);
    Route::get('/v1/promotions/{id}', [PromotionController::class, 'show']);
    Route::patch('/v1/promotions/{id}', [PromotionController::class, 'update']);
    Route::post('/v1/promotions/{id}/uploads', [PromotionController::class, 'upload']);
    Route::patch('/v1/promotions/{id}/update-status', [PromotionController::class, 'updateStatus']);
    Route::delete('/v1/promotions/{id}', [PromotionController::class, 'destroy']);

    Route::post('/v1/notifications', [NotificationController::class, 'send']);
    Route::post('/v1/translate/roman-hindustani', [TranslationController::class, 'urduToRomanHindustani']);
    Route::get('/v1/visitors/stats', [VisitorStatsController::class, 'stats']);
    Route::get('/v1/visitors-summary', [VisitorsSummaryController::class, 'index']);
    Route::get('/v1/visitors-summary/download', [VisitorsSummaryController::class, 'downloadVisitorSummary']);
    Route::get('/v1/visitors-summary/{type}', [VisitorsSummaryController::class, 'byType']);
    Route::get('/v1/visitors-summary/{type}/download', [VisitorsSummaryController::class, 'downloadByType']);
});

require __DIR__ . '/quiz.php';

Route::get('/enews', [ENewsPaperController::class, 'index']);
Route::get('/enews/{id}', [ENewsPaperController::class, 'show']);
Route::get('/enews/search', [ENewsPaperController::class, 'search']);
Route::get('/guldastahs', [GuldastahController::class, 'index']);
Route::get('/guldastahs/{id}', [GuldastahController::class, 'show']);


Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/trending', [ArticleController::class, 'trendingArticles']);
Route::get('/articles/popular', [ArticleController::class, 'popularArticles']);
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::get('/articles/{id}/comments', [ArticleController::class, 'getCommentByArticleId']);
Route::get('/articles/{id}/related', [ArticleController::class, 'relatedArticles']);
Route::get('/articles/{id}/text-to-speech', [ArticleController::class, 'textToSpeech']);

Route::get('/comments', [ArticleCommentController::class, 'index']);
Route::post('/comments', [ArticleCommentController::class, 'store']);
Route::get('/comments/{id}', [ArticleCommentController::class, 'show']);

Route::get('/advertisements', [DigitalAdController::class, 'index']);

Route::get('/home', [HomePageController::class, 'homePage']);


Route::get('/editions', [EditionController::class, 'index']);

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'authenticate']);
Route::post('/auth/otp-login', [AuthController::class, 'authenticateViaEmailOTP']);

// An API for collecting visitor analytics
// No controller needed for this
Route::post('/visitor/analytics', [VisitorAnalyticController::class, 'store']);

Route::get('/videos/trending', [\App\Http\Controllers\Api\TrendingVideoController::class, 'index']);
