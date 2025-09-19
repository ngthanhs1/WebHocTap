<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoicesController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\TrangChinhController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

use App\Http\Controllers\RegisterController;

Route::get('/logout', [RegisterController::class, 'showForm'])->name('logout');
Route::post('/logout', [RegisterController::class, 'register'])->name('logout.post');
Route::post('/signout',[AuthController::class, 'logout'])->name('signout');

Route::get('/Thuvien','App\Http\Controllers\ThuvienController@displayThuvien');

// Route cho trang chính
Route::get('/trangchinh', [TrangChinhController::class, 'index'])->middleware('auth')->name('trangchinh');

Route::middleware('auth')->group(function () {
    // Route cho trang tạo câu hỏi
    Route::get('/cauhoi', [QuestionController::class, 'create'])->name('cauhoi.create');
    Route::post('/cauhoi/save-session', [QuestionController::class, 'saveToSession'])->name('cauhoi.save-session');
    
    // Route cho chủ đề
    Route::get('/chude/create', [TopicController::class, 'create'])->name('chude.create');
    Route::post('/chude', [TopicController::class, 'store'])->name('chude.store');
    
    Route::resource('topics', TopicController::class)->only(['index','show']);

    Route::post('/topics/{topic}/questions', [QuestionController::class, 'store'])
        ->name('questions.store');

    Route::post('/questions/{question}/choices', [ChoicesController::class, 'store'])
        ->name('choices.store');

    Route::post('/thongke', [ThongKeController::class, 'store'])
        ->name('thongke.store');

    Route::get('/thongke', [ThongKeController::class, 'index'])
        ->name('thongke.index');
});