<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\DeliveryController;
//　use App\Http\Controllers\Admin\LoginController;
//　use App\Http\Controllers\Admin\RegisterController;
//　use App\Http\Controllers\Admin\TopController;
//　use App\Http\Controllers\Admin\ArticleController;
//　use App\Http\Controllers\Admin\BannerController;


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
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login'); // ログアウト後の遷移先
})->name('logout');

Route::get('/', function () {
    return view('/admin');
});

// 管理画面ルート
Route::prefix('admin')
    ->namespace('Admin')
    ->name('admin.')
    ->group(function () {

        Route::get('login', function () {
            return 'ログイン画面ダミー';
        })->name('login');
        


        // ログイン画面
        //　Route::get('login', [LoginController::class,'showLoginForm'])->name('show.login');

        // ユーザー新規登録画面
        //　Route::get('register', [RegisterController::class,'showRegisterForm'])->name('show.register');

        // トップページ
        //　Route::get('top', [TopController::class,'TopController'])->name('show.top');

        // 授業一覧画面
        Route::get('curriculum_list',[CurriculumController::class, 'showCurriculumList'])->name('show.curriculum.list');

        // 授業新規登録画面
        Route::get('curriculum_create',function(){return '授業新規登録画面ダミー表示';
        })->name('show.curriculum.create');

        // 授業編集画面
// 授業編集画面
Route::get('curriculum_edit/{id}', [CurriculumController::class, 'edit'])->name('show.curriculum.edit');

        // 配信日時設定画面
        Route::get('delivery_edit/{id}', [DeliveryController::class, 'showDeliveryEdit'])->name('show.delivery.edit');
        Route::post('delivery_store/{id}', [DeliveryController::class, 'store'])->name('delivery.store');
        Route::delete('delivery/{id}', [DeliveryController::class, 'destroy'])
        ->name('delivery.destroy');

        // お知らせ一覧画面
        Route::get('article_list', function () {
            return '記事一覧ダミー画面';
        })->name('show.article.list');
        
        // お知らせ新規登録画面
        //　Route::get('article_create', [ArticleController::class,'showArticleCreate'])->name('show.article.create');

        // お知らせ編集画面
        //　Route::get('article_edit/{id}', [ArticleController::class,'showArticleEdit'])->name('show.article.edit');

        // バナー設定画面
        Route::get('banner_edit', function () {
            return 'バナー編集ダミー画面';
        })->name('show.banner.edit');

            // 授業更新処理
// 配信日時更新処理
Route::put('delivery_update/{id}', [DeliveryController::class, 'update'])
    ->name('delivery.update');

    // 授業更新処理
Route::put('curriculum_update/{id}', [CurriculumController::class, 'update'])
->name('curriculum.update');

Route::get('curriculums/filter/{gradeId}', [App\Http\Controllers\Admin\CurriculumController::class, 'filterByGrade'])
    ->name('curriculum.filter');


    
    });




