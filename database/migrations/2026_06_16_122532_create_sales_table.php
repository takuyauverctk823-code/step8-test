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
    public function up()
{
    Schema::create('sales', function (Blueprint $table) {
        $table->id(); // 自動で増えるID
        
        // どの商品が売れたかを記録する外部キー（productsテーブルのidと紐づけ）
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        
        $table->timestamps(); // 作成日時・更新日時 (created_at, updated_at)
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
