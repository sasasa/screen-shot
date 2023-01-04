<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreenShotController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SiteController as AdminSiteController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::redirect('/', '/sites', 301);

Route::get('/sites/tags', [SiteController::class, 'tags'])->name('sites.tags');
Route::resource('sites', SiteController::class);

Route::group(['prefix' => 'system_admin', 'middleware' => ['guest:admin']], function () {
    // ログイン
    Route::get('/login', [LoginController::class, 'login'])->name('system_admin.login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('system_admin.authenticate');
});
Route::group(['prefix' => 'system_admin', 'middleware' => ['auth:admin', 'login_require', ]], function () {
    // 管理ページトップ
    Route::get('/sites', [AdminSiteController::class, 'index'])->name('system_admin.sites.index');
    Route::delete('/sites/{site}', [AdminSiteController::class, 'destroy'])->name('system_admin.sites.destroy');
    Route::put('/sites/{site}', [AdminSiteController::class, 'update'])->name('system_admin.sites.update');
    Route::get('/sites/{site}/edit', [AdminSiteController::class, 'edit'])->name('system_admin.sites.edit');
    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('system_admin.logout');
});



Route::get('/screen_shot/{url}', ScreenShotController::class)->where(['url' => '.*']);