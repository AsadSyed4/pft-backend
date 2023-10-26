<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\FeedbackController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/check-username', 'check_username');
    Route::post('/check-email', 'check_email');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', 'logout');
    });
});
Route::prefix('feedback')->controller(FeedbackController::class)->group(function () {
    Route::get('/all', 'get');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/{id}', 'get_by_id');
        Route::post('/add', 'add');
    });
});
Route::prefix('comment')->middleware('auth:sanctum')->controller(CommentController::class)->group(function () {
    Route::post('/add', 'add');
});
