<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    //管理画面トップページ・カテゴリー一覧表示
    Route::get('top', [CategoryController::class, 'top'])->name('top');

    //カテゴリー管理
    Route::prefix('categories')->name('categories.')->group(function () {
        //カテゴリー新規登録画面
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        //カテゴリー新規登録処理
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        //カテゴリー詳細画面表示
        Route::get('{categoryId}', [CategoryController::class, 'show'])->name('show');
        //カテゴリー編集画面表示
        Route::get('{categoryId}/edit', [CategoryController::class, 'edit'])->name('edit');
        //カテゴリー更新処理
        Route::post('{categoryId}/update', [CategoryController::class, 'update'])->name('update');
        //カテゴリー削除処理
        Route::post('{categoryId}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
    });
});
