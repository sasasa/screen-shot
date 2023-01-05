<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreenShotController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SiteController as AdminSiteController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\ContactController;

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
    // サイト管理
    Route::get('/sites', [AdminSiteController::class, 'index'])->name('system_admin.sites.index');
    Route::delete('/sites/{site}', [AdminSiteController::class, 'destroy'])->name('system_admin.sites.destroy');
    Route::put('/sites/{site}', [AdminSiteController::class, 'update'])->name('system_admin.sites.update');
    Route::put('/sites/{site}/colors', [AdminSiteController::class, 'update_colors'])->name('system_admin.sites.update_colors');
    Route::put('/sites/{site}/tags', [AdminSiteController::class, 'update_tags'])->name('system_admin.sites.update_tags');
    Route::put('/sites/{site}/crawl', [AdminSiteController::class, 'crawl'])->name('system_admin.sites.crawl');
    Route::get('/sites/{site}/edit', [AdminSiteController::class, 'edit'])->name('system_admin.sites.edit');

    // お問い合わせ
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('system_admin.contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('system_admin.contacts.show');
    Route::put('/contacts/{contact}', [AdminContactController::class, 'update'])->name('system_admin.contacts.update');

    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('system_admin.logout');
});

Route::resource('contacts', ContactController::class);
Route::get('/contact_us', [ContactController::class, 'create'])->name('contact_us');
Route::get('/terms', ScreenShotController::class)->name('terms');
Route::get('/privacy', ScreenShotController::class)->name('privacy');
Route::get('/screen_shot/{url}', ScreenShotController::class)->where(['url' => '.*']);