<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\LanguageController;
use Illuminate\Support\Facades\Route;

Auth::routes();

// \Illuminate\Support\Facades\URL::forceScheme('https');

Route::get('/login/mfe', [LoginController::class, 'showAdminLoginForm'])->name('admin.login.get');
Route::post('/login/mfe', [LoginController::class, 'adminLogin'])->name('admin.login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::any('login', function () {
    return redirect()->route('client.auth.login');
});
Route::any('register', function () {
    return redirect()->route('client.auth.register');
});


// ================================= ADMIN/CLIENT (domain vs local) ========================================
if (app()->environment('local')) {
    // On local, expose CP under /cp to avoid conflicts with site routes
    Route::group(['namespace' => 'CP', 'middleware' => ['web', 'auth.admin'], 'prefix' => 'cp'], function () {
        require __DIR__.'/cp/cp.php';
    });

    // Client routes on local without domain constraint
    Route::group(['as' => 'client.', 'middleware' => ['web']], function () {
        require __DIR__.'/site/site.php';
    });

    // Public GET route without /cp prefix for local testing (by appId)
    Route::get('orders/stream-video/{appId}', [\App\Http\Controllers\CP\OrderController::class, 'streamVideo'])->name('orders.video.stream');
    Route::get('video/{appId}', [\App\Http\Controllers\CP\OrderController::class, 'streamVideo'])->name('orders.video.stream');
} else {
    // Production domains
    Route::group(['namespace' => 'CP', 'middleware' => ['web', 'auth.admin'], 'domain' => 'vrectest.embafinans.az:7443'], function () {
        require __DIR__.'/cp/cp.php';
    });

    Route::group(['as' => 'client.', 'middleware' => ['web'], 'domain' => 'vrecord.embafinans.az'], function () {
        require __DIR__.'/site/site.php';
    });

}
