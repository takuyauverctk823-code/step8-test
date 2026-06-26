<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'nullable|string|max:1000',
            'product_image'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_name'  => '商品名',
            'company_id'    => 'メーカー',
            'price'         => '価格',
            'stock'         => '在庫数',
            'comment'       => 'コメント',
            'product_image' => '商品画像',
        ];
    }
}