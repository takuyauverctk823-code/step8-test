<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 保存・変更を許可するカラムを指定
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'image_path',
    ];

    // リレーション：商品は特定の1つの企業（Company）に属する
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // リレーション：1つの商品はたくさんの売上（Sales）を持つ
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}