<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    \App\Models\Product::create([
        'company_id' => 1, // コカ・コーラ
        'product_name' => 'コーラ',
        'price' => 160,
        'stock' => 20,
        'comment' => '定番の炭酸飲料です。',
        'image_path' => null,
    ]);

    \App\Models\Product::create([
        'company_id' => 2, // サントリー
        'product_name' => 'ボス コーヒー',
        'price' => 140,
        'stock' => 15,
        'comment' => '働く人の相棒。',
        'image_path' => null,
    ]);
}
}
