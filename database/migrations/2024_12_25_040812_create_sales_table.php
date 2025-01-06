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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId("member_id")->nullable()->constrained()->cascadeOnDelete();
            $table->integer("total_item");
            $table->integer("total_price");
            $table->tinyInteger("discount")->default(0);
            $table->integer("pay")->default(0);
            $table->integer("accepted")->default(0);
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
