<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgressController;

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

// ユーザー本人専用の進捗画面
Route::middleware(['auth'])->group(function() {
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
    Route::post('/progress/toggle', [ProgressController::class, 'toggle'])->name('progress.toggle');
});
