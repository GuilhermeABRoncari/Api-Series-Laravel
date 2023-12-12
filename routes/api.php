<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\EpisodeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::patch('/account', [UserController::class, 'update']);
    Route::delete('/account/{user_id}', [UserController::class, 'destroy']);

    Route::apiResource('/series', SeriesController::class);
    Route::get('/series/{series}/seasons', [SeasonController::class, 'index']);
    Route::get('/series/{series}/episodes', [EpisodeController::class, 'EpisodesBySeries']);
    Route::patch('/episodes/{episode}', [EpisodeController::class, 'update']);
});
