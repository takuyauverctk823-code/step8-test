<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController; // 1回だけに整理
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. トップページ
Route::get('/', function () {
    return view('welcome');
});

// 2. 認証が必要な画面グループ（ログイン後のみアクセス可能）
Route::middleware(['auth'])->group(function () {

    // ダッシュボード（Breeze標準）
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    // プロフィール管理（Breeze標準）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📦 商品管理用のルーティング
    // Route::resource を使うと、index, create, store, show, edit, update, destroy の7つが自動でこのグループ内に登録されます
    Route::resource('products', ProductController::class);

});

// 3. 認証関連のルーティング（Breezeのログイン・登録機能などを読み込み）
require __DIR__.'/auth.php';