<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['product_id'];

    // リレーション：売上データは特定の1つの商品（Product）に属する
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}