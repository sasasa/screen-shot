<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreenShotController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProductionLoginController;
use App\Http\Controllers\Admin\SiteController as AdminSiteController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\NgWordController as AdminNgWordController;
use App\Http\Controllers\Admin\ProductionController as AdminProductionController;
use App\Http\Controllers\Production\SiteController as ProductionSiteController;
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
// お問い合わせ
Route::resource('contacts', ContactController::class);
Route::get('/contact_us', [ContactController::class, 'create'])->name('contact_us');
// 利用規約
Route::get('/terms', [TermsController::class, 'index'])->name('terms');
// プライバシーポリシー
Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');
Route::get('/screen_shot/{url}', ScreenShotController::class)->where(['url' => '.*']);



/**
 * Production
 */
// ProductionLoginControllerでグループ化する


Route::controller(ProductionLoginController::class)->prefix('production')->name("production.")->middleware(['guest:production'])->group(function () {
    // 登録
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'register')->name('register_post');
    Route::get('/confirm/{url}', 'confirm')->name('confirm');
    // ログイン
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
});
Route::group(['as' => 'production.', 'prefix' => 'production', 'middleware' => ['auth:production']], function () {
    // ログアウト
    Route::post('/logout', [ProductionLoginController::class, 'logout'])->name('logout');
    // サイト削除
    // サイト管理
    Route::controller(ProductionSiteController::class)->prefix('sites')->name("sites.")->group(function () {
        Route::get('/{site}/edit', 'edit')->name('edit');
        Route::delete('/{site}', 'destroy')->name('destroy');
        Route::put('/{site}', 'update')->name('update');
        Route::put('/{site}/colors', 'update_colors')->name('update_colors');
        Route::put('/{site}/tags', 'update_tags')->name('update_tags');
        Route::put('/{site}/crawl', 'crawl')->name('crawl');
    });
});
Route::group(['middleware' => ['auth:production']], function () {
    Route::resource('production', ProductionController::class);
});


/**
 * Admin
 */
Route::group(['as' => 'system_admin.', 'prefix' => 'system_admin', 'middleware' => ['guest:admin']], function () {
    // ログイン
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
});
Route::group(['as' => 'system_admin.', 'prefix' => 'system_admin', 'middleware' => ['auth:admin', 'login_require', ]], function () {
    // サイト管理
    Route::controller(AdminSiteController::class)->prefix('sites')->name("sites.")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{site}/edit', 'edit')->name('edit');
        Route::delete('/{site}', 'destroy')->name('destroy');
        Route::put('/{site}', 'update')->name('update');
        Route::put('/{site}/colors', 'update_colors')->name('update_colors');
        Route::put('/{site}/tags', 'update_tags')->name('update_tags');
        Route::put('/{site}/crawl', 'crawl')->name('crawl');
    });
    // お問い合わせ
    Route::controller(AdminContactController::class)->prefix('contacts')->name("contacts.")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{contact}', 'show')->name('show');
        Route::put('/{contact}', 'update')->name('update');
    });
    // 企業管理
    Route::controller(AdminProductionController::class)->prefix('productions')->name("productions.")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{production}/edit', 'edit')->name('edit');
        Route::post('/{production}', 'update')->name('update');
        Route::delete('/{production}', 'destroy')->name('destroy');
        Route::patch('/{production}', 'restore')->name('restore');
    });

    // NGワード
    Route::resource('ng_words', AdminNgWordController::class);
    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
