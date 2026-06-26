<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 作成した CompaniesTableSeeder を呼び出す
        $this->call(CompaniesTableSeeder::class);
    }
}
