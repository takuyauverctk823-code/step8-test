<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // 画面を表示
    public function showRegistrationForm()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php を表示
    }

    // 登録処理
   public function register(Request $request)
    {
        // 1. 入力チェックを行う
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 2. データベースへの登録処理
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. 登録完了後、ログイン画面へリダイレクト
        return redirect()->route('login')->with('success', 'ユーザー登録が完了しました。');
    }}