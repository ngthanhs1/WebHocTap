<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TopicApiController;

// Topic RESTful API routes
Route::apiResource('topics', TopicApiController::class);
