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

// Route cho trang chính
Route::get('/trangchinh', [TrangChinhController::class, 'index'])->middleware('auth')->name('trangchinh');

Route::middleware('auth')->group(function () {
    // Route cho trang tạo câu hỏi
    Route::get('/cauhoi', [QuestionController::class, 'create'])->name('cauhoi.create');
    Route::post('/cauhoi/save-session', [QuestionController::class, 'saveToSession'])->name('cauhoi.save-session');
    
    // Route cho chủ đề
    Route::get('/chude/create', [TopicController::class, 'create'])->name('chude.create');
    Route::post('/chude', [TopicController::class, 'store'])->name('chude.store');
    Route::get('/topics/select', [TopicController::class, 'selectForQuestions'])->name('topics.select');
    Route::post('/topics/{topic}/add-questions', [TopicController::class, 'addQuestions'])->name('topics.add-questions');
    
    // CRUD routes cho Topics
    Route::resource('topics', TopicController::class);
    
    // Study và Test routes
    Route::get('/topics/{topic}/study', [TopicController::class, 'study'])->name('topics.study');
    Route::get('/topics/{topic}/test', [TopicController::class, 'test'])->name('topics.test');
    Route::post('/topics/{topic}/test-submit', [TopicController::class, 'testSubmit'])->name('topics.test.submit');

    // CRUD routes cho Questions
    Route::resource('questions', QuestionController::class)->except(['index']);
    Route::post('/topics/{topic}/questions', [QuestionController::class, 'store'])
        ->name('topics.questions.store');

    // CRUD routes cho Choices
    Route::post('/questions/{question}/choices', [ChoicesController::class, 'store'])
        ->name('choices.store');
    Route::put('/choices/{choice}', [ChoicesController::class, 'update'])
        ->name('choices.update');
    Route::delete('/choices/{choice}', [ChoicesController::class, 'destroy'])
        ->name('choices.destroy');



});

// Route để refresh CSRF token
Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
})->name('refresh.csrf');