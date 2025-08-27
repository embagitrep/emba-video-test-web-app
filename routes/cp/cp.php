<?php

use App\Http\Controllers\CP\AjaxController;
use App\Http\Controllers\CP\GalleryController;
use App\Http\Controllers\CP\MainController;
use App\Http\Controllers\CP\MerchantController;
use App\Http\Controllers\CP\NotificationController;
use App\Http\Controllers\CP\OrderController;
use App\Http\Controllers\CP\SettingController;
use App\Http\Controllers\CP\SmsLogController;
use App\Http\Controllers\CP\TranslationController;
use App\Http\Controllers\CP\UploadController;
use App\Http\Controllers\CP\UserController;

Route::get('/', [MainController::class, 'index'])->name('admin.index');
Route::get('/clear-cache', [MainController::class, 'clearCache'])->name('admin.clear.cache');
Route::get('/translation-to-file', [MainController::class, 'translationsToFile'])->name('admin.translates.to.file');

//    ================= Plupload Image Upload, delete & sort =========================================
Route::any('/upload/{type}/{parent}', [UploadController::class, 'upload'])->name('upload');
Route::any('/getLastUploaded/{type}/{parent}',
    [UploadController::class, 'getLastUploaded'])->name('getLastUploaded');
Route::get('/deleteGallery/{id}', [UploadController::class, 'deleteGallery'])->name('deleteGallery');
Route::post('/editGallery/{id}/{parent?}', [GalleryController::class, 'editGallery'])->name('editGallery');
Route::post('/sortUploaded', [UploadController::class, 'sortUploaded'])->name('sortUploaded');



//    ================= Helper Controllers ===========================================================

Route::group(['prefix' => 'ajax'], function () {
    Route::get('/checkSlug/{type}', [AjaxController::class, 'strSlug'])->name('admin.str.slug');
    Route::get('/activatePost/{id}/{type}/{active}', [AjaxController::class, 'activatePost'])->name('admin.activatePost');
    Route::get('/frontPost/{id}/{type}/{front}', [AjaxController::class, 'frontPost'])->name('admin.frontPost');
});

//    ================================================================================================


Route::group(['prefix' => 'user'], function () {
    Route::any('/add', [UserController::class, 'add'])->name('user.add');
    //    Route::any('/reset', 'UserController@reset')->name('user.reset');
    Route::get('/all', [UserController::class, 'all'])->name('user.all');
    Route::any('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::any('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/transactions/{id}', [UserController::class, 'transactions'])->name('user.transactions');
    Route::get('/notifications/{id}', [UserController::class, 'userNotifications'])->name('user.notifications');
    Route::post('notification/{id}', [UserController::class, 'sendNotification'])->name('user.send.notification');
});

Route::group(['prefix' => 'translations'], function () {
    Route::get('/', [TranslationController::class, 'all'])->name('admin.translations');
    Route::post('/{file_name}/{key}/add', [TranslationController::class, 'add'])->name('admin_translations_add');
    Route::any('/{translation}', [TranslationController::class, 'edit'])->name('admin.translation.edit');
    Route::post('/', [TranslationController::class, 'add'])->name('admin.translation.add');
});

Route::group(['prefix' => 'settings'], function () {
    Route::get('/', [SettingController::class, 'all'])->name('admin.settings');
    Route::any('/{setting}', [SettingController::class, 'edit'])->name('admin.setting.edit');
    Route::get('/image/regenerate-image',
        [SettingController::class, 'regenerateImages'])->name('admin.setting.regenerateImages');
});

Route::get('/videos/{appId}',[OrderController::class, 'videosPublic'])->name('admin.video.public')->withoutMiddleware('auth.admin');

Route::group(['prefix' => 'sent-sms'], function () {
    Route::get('/', [SmsLogController::class, 'index'])->name('admin.sent.sms.index');
});

Route::group(['prefix' => 'orders'], function () {
    Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('videos/{merchant}/{appId}',[OrderController::class, 'videos'])->name('admin.orders.videos');
    Route::get('stream-video/{order}',[OrderController::class, 'streamVideo'])->name('admin.orders.video.stream')->withoutMiddleware('auth.admin');
    Route::match(['HEAD'], 'stream-video/{appId}', [OrderController::class, 'headStreamVideoByAppId'])->name('admin.orders.video.stream.head')->withoutMiddleware('auth.admin');
});

Route::group(['prefix' => 'merchants'], function () {
    Route::get('/', [MerchantController::class, 'index'])->name('admin.merchant.index');
    Route::get('/add', [MerchantController::class, 'add'])->name('admin.merchant.add');
    Route::post('/store', [MerchantController::class, 'store'])->name('admin.merchant.store');
    Route::get('/{merchant}/edit', [MerchantController::class, 'edit'])->name('admin.merchant.edit');
    Route::post('/{merchant}/update', [MerchantController::class, 'update'])->name('admin.merchant.update');
    Route::any('/{merchant}/delete', [MerchantController::class, 'delete'])->name('admin.merchant.delete');
});

Route::group(['prefix' => 'notifications'], function () {
    Route::get('markAsRead/{id}', [NotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead');
    Route::get('delete/{id}', [NotificationController::class, 'delete'])->name('admin.notifications.delete');
    Route::get('markAllAsRead', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead');
});
