<?php

use App\Http\Controllers\User\Auth\ProfileController;
use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // 最初にloginにリダイレクトする
    return redirect()->route('login');
});

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/progress', [ProgressController::class, 'index'])
        ->name('progress.index');   

    Route::post('/progress/toggle', [ProgressController::class, 'toggle'])
        ->name('progress.toggle');

    //
    Route::get('/curriculums/{id}', function($id){
        return "授業ID {$id} の配信画面（仮）";
    });
     
    // デモ用：「受講しました」ボタン    
    Route::post('/progress/complete/{curriculum}', [ProgressController::class, 'complete'])
        ->name('progress.complete');    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('user.profile.update');

    Route::get('/password', [ProfileController::class, 'editPassword'])->name('user.password.edit');
    Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('user.password.update');
});

require __DIR__.'/auth.php';
