<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ams\CategoryPageController;

Route::prefix('ams')->name('ams.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        // CMS Pages Routes
        Route::prefix('cms')->name('cms.')->group(function () {
            Route::get('/pages', [CategoryPageController::class, 'index'])->name('pages.index');
            Route::get('/pages/create', [CategoryPageController::class, 'create'])->name('pages.create');
            Route::post('/pages', [CategoryPageController::class, 'store'])->name('pages.store');
            Route::get('/pages/{page}/edit', [CategoryPageController::class, 'edit'])->name('pages.edit');
            Route::put('/pages/{page}', [CategoryPageController::class, 'update'])->name('pages.update');
            Route::delete('/pages/{page}', [CategoryPageController::class, 'destroy'])->name('pages.destroy');
            Route::post('/upload-image', [CategoryPageController::class, 'uploadImage'])->name('upload.image');
        });
    });
});
