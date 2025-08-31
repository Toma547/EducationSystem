<?php

use Illuminate\Support\Facades\Route;

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
        Route::get('/login', 'LoginController@showLoginForm')->name('show.login');

        // ユーザー新規登録画面
        Route::get('/register', 'RegisterController@showRegisterForm')->name('show.register');

        // トップページ
        Route::get('/top', 'TopController@showTop')->name('show.top');

        // 授業一覧画面
        Route::get('/curriculum_list', 'CurriculumController@showCurriculumList')->name('show.curriculum.list');

        // 授業新規登録画面
        Route::get('/curriculum_create', 'CurriculumController@showCurriculumCreate')->name('show.curriculum.create');

        // 授業編集画面
        Route::get('/curriculum_edit/{id}', 'CurriculumController@showCurriculumEdit')->name('show.curriculum.edit');

        // 配信日時設定画面
        Route::get('/delivery_edit/{id}', 'DeliveryController@showDeliveryEdit')->name('show.delivery.edit');

        // お知らせ一覧画面
        Route::get('/article_list', 'ArticleController@showArticleList')->name('show.article.list');

        // お知らせ新規登録画面
        Route::get('/article_create', 'ArticleController@showArticleCreate')->name('show.article.create');

        // お知らせ編集画面
        Route::get('/article_edit/{id}', 'ArticleController@showArticleEdit')->name('show.article.edit');

        // バナー設定画面
        Route::get('/banner_edit', 'BannerController@showBannerEdit')->name('show.banner.edit');
});
