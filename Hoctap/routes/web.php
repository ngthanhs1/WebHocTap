<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoicesController;
use App\Http\Controllers\ThongKeController;


Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

Route::get('/Thuvien','App\Http\Controllers\ThuvienController@displayThuvien');

Route::middleware('auth')->group(function () {
    Route::resource('topics', TopicController::class)->only(['index','create','store','show']);

    Route::post('/topics/{topic}/questions', [QuestionController::class, 'store'])
        ->name('questions.store');

    Route::post('/questions/{question}/choices', [ChoicesController::class, 'store'])
        ->name('choices.store');

    Route::post('/thongke', [ThongKeController::class, 'store'])
        ->name('thongke.store');

    Route::get('/thongke', [ThongKeController::class, 'index'])
        ->name('thongke.index');
});