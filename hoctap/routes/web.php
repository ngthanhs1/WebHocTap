<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThuVienController;
use App\Http\Controllers\DeThiWizardController;
use App\Http\Controllers\DeThiManageController;
use App\Http\Controllers\CauHoiManageController;

// Vào trang chủ -> chuyển thẳng sang thư viện
Route::get('/', fn () => redirect()->route('library.index'));

Route::middleware('auth')->group(function () {
    // Thư viện của tôi
    Route::get('/thu-vien',       [ThuVienController::class, 'index'])->name('library.index');
    Route::post('/thu-vien/bulk', [ThuVienController::class, 'bulk'])->name('library.bulk');

    // Tạo quiz 1 màn
    Route::get ('/de-thi/create', [DeThiWizardController::class, 'create'])->name('de-thi.create');
    Route::post('/de-thi',        [DeThiWizardController::class, 'store'])->name('de-thi.store');

    // Chi tiết quiz + xuất bản/nháp
    Route::get ('/de-thi/{de_thi}', [DeThiManageController::class, 'show'])->name('de-thi.show');
    Route::put ('/de-thi/{de_thi}', [DeThiManageController::class, 'update'])->name('de-thi.update');
    Route::post('/de-thi/{de_thi}/publish',   [DeThiManageController::class, 'publish'])->name('de-thi.publish');
    Route::post('/de-thi/{de_thi}/unpublish', [DeThiManageController::class, 'unpublish'])->name('de-thi.unpublish');

    // CRUD câu hỏi
    Route::get   ('/de-thi/{de_thi}/cau-hoi/create',        [CauHoiManageController::class, 'create'])->name('de-thi.cau-hoi.create');
    Route::post  ('/de-thi/{de_thi}/cau-hoi',                [CauHoiManageController::class, 'store'])->name('de-thi.cau-hoi.store');
    Route::get   ('/de-thi/{de_thi}/cau-hoi/{cau_hoi}/edit', [CauHoiManageController::class, 'edit'])->name('de-thi.cau-hoi.edit');
    Route::put   ('/de-thi/{de_thi}/cau-hoi/{cau_hoi}',      [CauHoiManageController::class, 'update'])->name('de-thi.cau-hoi.update');
    Route::delete('/de-thi/{de_thi}/cau-hoi/{cau_hoi}',      [CauHoiManageController::class, 'destroy'])->name('de-thi.cau-hoi.destroy');
});

require __DIR__.'/auth.php';
