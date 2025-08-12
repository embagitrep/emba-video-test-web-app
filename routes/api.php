<?php

use App\Http\Controllers\Api\V1\OrderController;

Route::group(['middleware' => ['api.auth', 'api.version:v1']], function () {
    Route::group(['prefix' => 'orders'], function () {
        Route::post('/', [OrderController::class, 'store']);
    });
});
