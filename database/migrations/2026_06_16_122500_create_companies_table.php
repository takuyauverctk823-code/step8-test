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
    Schema::create('companies', function (Blueprint $table) { // ← Schema に修正
        $table->id();
        $table->string('company_name'); // 企業名
        $table->string('street_address')->nullable(); 
        $table->string('representative_name')->nullable(); 
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
        Schema::dropIfExists('companies');
    }
};
