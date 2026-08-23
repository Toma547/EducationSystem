<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\TopController;
use App\Http\Controllers\User\DeliveryController;
use App\Http\Controllers\User\CurriculumController;
use App\Http\Controllers\User\ArticleController;

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
    return redirect()->route('user.show.login');
});

//ユーザー用ルート
Route::prefix('user')->name('user.')->group(function () {
    //未ログインユーザー向け
    Route::middleware('guest')->group(function () {
        //ログイン
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('show.login');
        Route::post('login', [LoginController::class, 'login'])->name('login');
        //新規登録
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('show.register');
        Route::post('register', [RegisterController::class, 'register'])->name('register');
    });
    //認証後
    Route::middleware('auth')->group(function () {
        //ログアウト
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        //トップ画面表示
        Route::get('top', [TopController::class, 'showTop'])->name('show.top');
        //お知らせ詳細画面表示
        Route::get('articles/{id}', [ArticleController::class, 'showArticle'])->name('show.article');
        //配信画面表示
        Route::get('delivery/{id}', [DeliveryController::class, 'showDelivery'])->name('show.delivery');
        Route::post('delivery/{id}/complete', [DeliveryController::class, 'complete'])->name('complete.delivery');
        //時間割画面表示
        Route::get('curriculum_list', [CurriculumController::class, 'showCurriculumList'])->name('show.curriculum');
    });
});
