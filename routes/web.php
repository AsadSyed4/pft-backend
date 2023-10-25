<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(ClientController::class)->group(function () {
        Route::get('/clients', 'get')->name('clients.page');
        Route::delete('clients/{id}', 'destroy')->name('clients.destroy');
    });

    Route::controller(FeedbackController::class)->group(function () {
        Route::get('/feedbacks', 'get')->name('feedbacks.page');
        Route::get('/feedback/{id}', 'get_by_id')->name('feedbacks.id');
        Route::delete('feedbacks/{id}', 'destroy')->name('feedbacks.destroy');
    });

    Route::controller(CommentController::class)->group(function () {
        Route::post('/comments/change-visibility', 'change_visibility')->name('comments.change.visibility');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
    });

});

require __DIR__ . '/auth.php';
