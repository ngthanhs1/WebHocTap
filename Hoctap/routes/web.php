<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/Thuvien','App\Http\Controllers\ThuvienController@displayThuvien');
