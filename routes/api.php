<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Quiz\ApiQuizController;
use App\Http\Controllers\User\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/signup', [ApiAuthController::class, 'signup']);
});

Route::group(['middleware' => ['cors', 'json.response', 'auth:api']], function () {
    Route::get('/me', [ApiUserController::class, 'getOneUserByToken']);
    Route::put('/me', [ApiUserController::class, 'updateOneUserByToken']);

    Route::get('/quiz', [ApiQuizController::class, 'sendQuiz']);
    Route::get('/my/quiz', [ApiQuizController::class, 'getAllQuizByUser']);
    Route::post('/quiz', [ApiQuizController::class, 'addQuiz']);
});