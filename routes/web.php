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
use App\Http\Controllers\AuthController;

// ログイン画面を表示するルート
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// ログイン処理を実行するルート
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// 新規登録画面（仮のルーティング。エラー防止用）
Route::get('/register', function () {
    return '新規登録画面（未作成）';
});

use App\Http\Controllers\RegisterController;

// ユーザー新規登録画面を表示する
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// ユーザー新規登録処理を実行する
Route::post('/register', [RegisterController::class, 'register']);
use App\Http\Controllers\ProductController;

// 商品一覧（検索も同じURLのGETで行います）
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品削除処理
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');