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
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('total_item')->unsigned()->change();
            $table->integer('total_price')->unsigned()->change();
            $table->tinyInteger('discount')->default(0)->unsigned()->change();
            $table->integer('pay')->default(0)->unsigned()->change();
            $table->integer('accepted')->default(0)->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('total_item')->change();
            $table->integer('total_price')->change();
            $table->tinyInteger('discount')->default(0)->change();
            $table->integer('pay')->default(0)->change();
            $table->integer('accepted')->default(0)->change();
        });
    }
};
