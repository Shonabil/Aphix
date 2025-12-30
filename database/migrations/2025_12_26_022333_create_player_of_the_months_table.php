<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('player_of_the_months', function (Blueprint $table) {
        $table->id();
        $table->string('name');         // Nama Pemain
        $table->string('category');     // Contoh: "Most Disciplined", "Top Scorer", "MVP"
        $table->string('image');        // Foto Pemain
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_of_the_months');
    }
};
