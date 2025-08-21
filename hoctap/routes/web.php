<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{MonHocController,DeThiController,CauHoiController,DapAnController};

// Public: Catalog + Làm bài
Route::get('/', [DeThiController::class, 'catalog'])->name('catalog');
Route::get('/lam-bai/{de_thi}', [DeThiController::class, 'lamBai'])->name('de-thi.lam-bai');
Route::post('/nop-bai/{de_thi}', [DeThiController::class, 'nopBai'])->name('de-thi.nop-bai');

// Admin CRUD (sau này bọc middleware auth)
Route::resource('mon-hoc', MonHocController::class);
Route::resource('de-thi', DeThiController::class);
Route::resource('de-thi.cau-hoi', CauHoiController::class);   // /de-thi/{de_thi}/cau-hoi/*
Route::resource('cau-hoi.dap-an', DapAnController::class);    // /cau-hoi/{cau_hoi}/dap-an/*
