<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ログイン画面を表示する
    public function showLoginForm()
    {
        return view('login');
    }

    // ログイン処理を行う
    public function login(Request $request)
    {
        // 入力値のチェック（バリデーション）
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 認証を試みる
        if (Auth::attempt($credentials)) {
            // セッションの再生成
            $request->session()->regenerate();

            // 本来行きたかったページ、またはトップページにリダイレクト
            return redirect()->intended('/');
        }

        // 認証失敗時はエラーメッセージを返して戻る
        return back()->withErrors([
            'email' => 'アドレスまたはパスワードが正しくありません。',
        ])->onlyInput('email');
    }
}