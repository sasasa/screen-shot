<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreenShotController;
use App\Http\Controllers\SiteController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sites/tags', [SiteController::class, 'tags'])->name('sites.tags');
Route::resource('sites', SiteController::class);

Route::get('/screen_shot/{url}', ScreenShotController::class)->where(['url' => '.*']);