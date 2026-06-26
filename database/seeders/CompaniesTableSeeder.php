<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // 追加

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 既存のデータを一度クリアしたい場合は truncate を使います（必要に応じて）
        // DB::table('companies')->truncate();

        DB::table('companies')->insert([
            [
                'company_name' => 'サントリー',
                'street_address' => '東京都港区台場',
                'representative_name' => '鳥井信宏',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'キリン',
                'street_address' => '東京都中野区',
                'representative_name' => '磯崎功典',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'コカ・コーラ',
                'street_address' => '東京都港区赤坂',
                'representative_name' => 'ホルヘ・ガルドゥニョ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}