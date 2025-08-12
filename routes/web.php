<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\LanguageController;
use Illuminate\Support\Facades\Route;

Auth::routes();

// \Illuminate\Support\Facades\URL::forceScheme('https');

Route::get('/login/mfe', [LoginController::class, 'showAdminLoginForm'])->name('admin.login.get');
Route::post('/login/mfe', [LoginController::class, 'adminLogin'])->name('admin.login.post');

Route::any('login', function () {
    return redirect()->route('client.auth.login');
});
Route::any('register', function () {
    return redirect()->route('client.auth.register');
});


// ================================= ADMIN ===============================================================

Route::group(['namespace' => 'CP', 'middleware' => ['web', 'auth.admin'], 'domain' => 'vrec.embafinans.az'], function () {
    require __DIR__.'/cp/cp.php';
});
// ================================= END ADMIN ==============================================================

Route::group(['as' => 'client.',  'middleware' => ['web'], 'domain' => 'vrecord.embafinans.az'], function () {
    require __DIR__.'/site/site.php';
});
