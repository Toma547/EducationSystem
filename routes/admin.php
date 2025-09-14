<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Admin\Auth\AdminRegisterController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\ArticleController;



    // 管理者ログイン
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // 管理者新規登録
    Route::get('/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AdminRegisterController::class, 'register']);

    // 管理画面（認証必要）
    Route::middleware('auth:admin')->group(function () {
        Route::redirect('/dashboard', '/admin/articles');
        Route::resource('articles', ArticleController::class);
    });
