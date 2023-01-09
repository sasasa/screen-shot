<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreenShotController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProductionLoginController;
use App\Http\Controllers\Admin\SiteController as AdminSiteController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\NgWordController as AdminNgWordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\ProductionController;
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

Route::group(['as' => 'system_admin.', 'prefix' => 'system_admin', 'middleware' => ['guest:admin']], function () {
    // ログイン
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
});
Route::group(['as' => 'production.', 'prefix' => 'production', 'middleware' => ['guest:production']], function () {
    // 登録
    Route::get('/register', [ProductionLoginController::class, 'register'])->name('register');
    Route::post('/register', [ProductionLoginController::class, 'register']);
    Route::get('/confirm/{url}', [ProductionLoginController::class, 'confirm'])->name('confirm');
    // ログイン
    Route::get('/login', [ProductionLoginController::class, 'login'])->name('login');
    Route::post('/login', [ProductionLoginController::class, 'authenticate'])->name('authenticate');
});
Route::group(['as' => 'production.', 'prefix' => 'production', 'middleware' => ['auth:production']], function () {
    // ログアウト
    Route::post('/logout', [ProductionLoginController::class, 'logout'])->name('logout');
});
Route::group(['middleware' => ['auth:production']], function () {
    Route::resource('production', ProductionController::class);
});



Route::group(['as' => 'system_admin.', 'prefix' => 'system_admin', 'middleware' => ['auth:admin', 'login_require', ]], function () {
    // サイト管理
    Route::get('/sites', [AdminSiteController::class, 'index'])->name('sites.index');
    Route::delete('/sites/{site}', [AdminSiteController::class, 'destroy'])->name('sites.destroy');
    Route::put('/sites/{site}', [AdminSiteController::class, 'update'])->name('sites.update');
    Route::put('/sites/{site}/colors', [AdminSiteController::class, 'update_colors'])->name('sites.update_colors');
    Route::put('/sites/{site}/tags', [AdminSiteController::class, 'update_tags'])->name('sites.update_tags');
    Route::put('/sites/{site}/crawl', [AdminSiteController::class, 'crawl'])->name('sites.crawl');
    Route::get('/sites/{site}/edit', [AdminSiteController::class, 'edit'])->name('sites.edit');

    // お問い合わせ
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::put('/contacts/{contact}', [AdminContactController::class, 'update'])->name('contacts.update');

    // NGワード
    Route::resource('ng_words', AdminNgWordController::class);

    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// お問い合わせ
Route::resource('contacts', ContactController::class);
Route::get('/contact_us', [ContactController::class, 'create'])->name('contact_us');
// 利用規約
Route::get('/terms', [TermsController::class, 'index'])->name('terms');
// プライバシーポリシー
Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');
Route::get('/screen_shot/{url}', ScreenShotController::class)->where(['url' => '.*']);