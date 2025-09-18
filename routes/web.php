<?php

use App\Http\Controllers\User\CurriculumController;
use App\Http\Controllers\User\TopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CurriculumController as AdminCurriculumController;
use App\Http\Controllers\Admin\ArticleController;

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


Route::prefix('user')->name('user.')->group(function () {
    Route::get('/curriculum_list/{gradeId}/{yearMonth?}', [CurriculumController::class, 'showCurriculumList'])->name('show.curriculum');
    Route::get('/top', [TopController::class, 'showTop'])->name('show.top');
    Route::get('/delivery/{id}', [App\Http\Controllers\User\DeliveryController::class, 'showDelivery'])->name('show.delivery');
});

Auth::routes();



Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', function () {
        return view('admin.auth.login');
    })->name('login');

    Route::post('login', [LoginController::class, 'login']);

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('register', function () {
        return view('admin.auth.register');
    })->name('register');

    Route::post('register', [RegisterController::class, 'register']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('top', [AdminTopController::class, 'showTop'])->name('show.top');
        Route::get('banner_edit', [BannerController::class, 'showBannerEdit'])->name('show.banner.edit');
        Route::post('banner_edit', [BannerController::class, 'updateBanners'])->name('update.banners');
        Route::get('curriculum_list', [AdminCurriculumController::class, 'showCurriculumList'])->name('show.curriculum.list');
        Route::get('article_list', [ArticleController::class, 'showArticleList'])->name('show.article.list');
    });
});

