<?php

use App\Http\Controllers\User\CurriculumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\TopController;

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

Route::get('/curriculum_list/{gradeId}', [CurriculumController::class, 'showCurriculumList'])->name('show.curriculum');

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
        Route::get('top', [TopController::class, 'showTop'])->name('show.top');
    });
});
