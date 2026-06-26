<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        // foreignIdでcompaniesテーブルのidとリレーションを組みます
        $table->foreignId('company_id')->constrained()->onDelete('cascade'); 
        $table->string('product_name');
        $table->integer('price');
        $table->integer('stock');
        $table->text('comment')->nullable(); // 任意入力のためnullable
        $table->string('img_path')->nullable(); // 任意・画像パス保存用
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
