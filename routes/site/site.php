<?php

use App\Http\Controllers\Client\MainController;

Route::get('/{sessionId}', [MainController::class, 'index'])->name('index');
Route::post('upload-video/{sessionId}', [MainController::class, 'uploadVideo'])->name('upload.video')->middleware('ajax.post.request');
