<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TopicApiController;
use App\Http\Controllers\Api\QuestionApiController;
use App\Http\Controllers\Api\ChoiceApiController;
use App\Http\Controllers\Api\UserApiController;

// Topic RESTful API routes
Route::apiResource('topics', TopicApiController::class);

// Question RESTful API routes
Route::apiResource('questions', QuestionApiController::class);

// Choice RESTful API routes
Route::apiResource('choices', ChoiceApiController::class);

// Demo: JSON input echo endpoint
Route::post('users/json-input', [UserApiController::class, 'jsonInputPostUser']);
