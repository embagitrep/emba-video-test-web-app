<?php

use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\UploadController;
use App\Http\Controllers\CP\OrderController as CPOrderController;

Route::group(['middleware' => ['api.auth', 'api.version:v1']], function () {
    Route::group(['prefix' => 'orders'], function () {
        Route::post('/', [OrderController::class, 'store']);
    });
    Route::group(['prefix' => 'upload'], function () {
        // Mobile app direct upload via session token
        Route::post('/video', [UploadController::class, 'video']);
    });
});

// Public watch URL for streaming uploaded video without CP prefix
Route::get('/watch/{order}', [CPOrderController::class, 'streamVideo'])->name('api.video.watch');
