<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // プログラム側から一括で保存・変更を許可するカラムを指定
    protected $fillable = ['company_name'];

    // リレーション：1つの企業はたくさんの商品（Products）を持つ
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}