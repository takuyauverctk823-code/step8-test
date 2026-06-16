<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーログイン画面</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            width: 400px;
            text-align: center;
        }
        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
            font-weight: normal;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group input {
            width: 100%;
            padding: 12px 0;
            font-size: 16px;
            border: none;
            border-bottom: 1px solid #ccc;
            outline: none;
            background: transparent;
        }
        .input-group input::placeholder {
            color: #999;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .btn {
            width: 45%;
            padding: 10px 0;
            font-size: 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }
        .btn-register {
            background-color: #f39c12; /* オレンジ */
        }
        .btn-login {
            background-color: #4edcd6; /* 水色 */
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>ユーザーログイン画面</h2>
   
    <!-- エラーメッセージ表示用 -->
    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px; text-align: left;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
       
        <div class="input-group">
            <input type="password" name="password" placeholder="パスワード" required>
        </div>
       
        <div class="input-group">
            <input type="email" name="email" placeholder="アドレス" required value="{{ old('email') }}">
        </div>

        <div class="button-group">
            <button type="button" class="btn btn-register" onclick="location.href='/register'">新規登録</button>
            <button type="submit" class="btn btn-login">ログイン</button>
        </div>
    </form>
</div>

</body>
</html>