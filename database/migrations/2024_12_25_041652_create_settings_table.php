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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("company_name")->unique();
            $table->text("address")->nullable();
            $table->string("phone");
            $table->tinyInteger("note_type");
            $table->tinyInteger("discount")->default(0);
            $table->string("path_logo");
            $table->string("path_card_member");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
