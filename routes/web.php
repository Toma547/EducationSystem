<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\TopController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BannerController;


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

// 管理画面ルート
Route::prefix('admin')
    ->namespace('Admin')
    ->name('admin.')
    ->group(function () {

        // ログイン画面
        Route::get('/admin/login', [LoginController::class,'showLoginForm'])->name('show.login');

        // ユーザー新規登録画面
        Route::get('/admin/register', [RegisterController::class,'showRegisterForm'])->name('show.register');

        // トップページ
        Route::get('/admin/top', [TopController::class,'TopController'])->name('show.top');

        // 授業一覧画面
        Route::get('/admin/curriculum_create',[CurriculumController::class, 'showCurriculumList'])->name('show.curriculum.list');

        // 授業新規登録画面
        Route::get('/admin/curriculum_create', [CurriculumController::class,'showCurriculumCreate'])->name('show.curriculum.create');

        // 授業編集画面
        Route::get('/admin/curriculum_edit/{id}', [CurriculumController::class,'showCurriculumEdit'])->name('show.curriculum.edit');

        // 配信日時設定画面
        Route::get('/admin/delivery_edit/{id}', [DeliveryController::class,'showDeliveryEdit'])->name('show.delivery.edit');

        // お知らせ一覧画面
        Route::get('/admin/article_list', [ArticleController::class,'showArticleList'])->name('show.article.list');

        // お知らせ新規登録画面
        Route::get('/admin/article_create', [ArticleController::class,'showArticleCreate'])->name('show.article.create');

        // お知らせ編集画面
        Route::get('/admin/article_edit/{id}', [ArticleController::class,'showArticleEdit'])->name('show.article.edit');

        // バナー設定画面
        Route::get('/admin/banner_edit', [BannerController::class,'showBannerEdit'])->name('show.banner.edit');
});
