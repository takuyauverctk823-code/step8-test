<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 認証チェックを有効にする場合はここを調整
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // confirmedによりpassword_confirmationと一致するか検証
        ];
    }

    public function attributes(): array
    {
        return [
            'name'     => 'ユーザ名',
            'email'    => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }
}