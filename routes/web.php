<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\EPaperController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\QuizAppController;
use App\Http\Controllers\TrendingVideoController;
use App\Http\Controllers\AdminAppController;
use App\Http\Controllers\AdsTrackController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\GuldastahController;
use App\Http\Controllers\login\LoginController;
use App\Http\Controllers\LanguagePrefController;
use App\Http\Controllers\login\RegisterController;
use App\Http\Controllers\AdvertisementBookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Redirect old blade login/register routes to the React admin SPA
Route::get('/register', function () {
    return redirect('/app/login');
})->name('register');

Route::get('/login', function () {
    return redirect('/app/login');
})->name('login');


Route::get('/', [HomeController::class, 'index'])->middleware('track_visitor');
Route::get('/about', [AboutController::class, 'index']);
Route::get('/advertisement-booking', [AdvertisementBookingController::class, 'index']);
Route::get('/terms', [TermsController::class, 'index']);
Route::get('/privacy', [PrivacyController::class, 'index']);
Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/guldastah', [GuldastahController::class, 'index']);
Route::get('/guldastah/{id}', [GuldastahController::class, 'show']);
Route::get('/guldastah/{id}/{page}', [GuldastahController::class, 'show']);
Route::get('/epaper', [EPaperController::class, 'index']);
Route::get('/epaper/{id}', [EPaperController::class, 'show']);
Route::get('/epaper/{id}/{page}', [EPaperController::class, 'show']);
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/category/{slug}', [ArticleController::class, 'indexByCategory']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
Route::get('/api/articles/{id}/translate', [ArticleController::class, 'translate']);
Route::post('/comment/store', [CommentController::class, 'store']);
Route::post('/vote/store', [VoteController::class, 'store']);
Route::get('/ad-track/{id}', [AdsTrackController::class, 'store']);
Route::get('/thankyou', [ContactController::class, 'thankYou'])->name('thankyou');
Route::get('/social', [SocialController::class, 'index']);
Route::get('/trending-videos', [TrendingVideoController::class, 'index']);
Route::redirect('/videos', '/trending-videos');

Route::get('/lang-pref/{lang}', LanguagePrefController::class);


Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout']);


// This routes are for SPA (frontend of admin panel).
// This catches all the URLs that are prefixed with /app
$spaRegex = '^((?!api).)*?';

Route::get('/app', [AdminAppController::class, 'index']);
Route::get('/app/{all}', [AdminAppController::class, 'index'])->where('all', $spaRegex);

Route::get('/quiz/host', [QuizAppController::class, 'host']);
Route::get('/quiz/host/{all}', [QuizAppController::class, 'host'])->where('all', $spaRegex);
Route::get('/quiz/player', [QuizAppController::class, 'player']);
Route::get('/quiz/player/{all}', [QuizAppController::class, 'player'])->where('all', $spaRegex);


