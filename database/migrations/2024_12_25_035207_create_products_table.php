<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("code")->unique();
            $table->string("name")->unique();
            $table->foreignId("category_id")->constrained()->restrictOnDelete()->restrictOnUpdate();
            $table->string("brand")->nullable();
            $table->integer("price");
            $table->tinyInteger("discount")->default(0);
            $table->integer("sell_price");
            $table->integer("stock");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
