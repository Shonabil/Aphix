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
    Schema::create('landing_galleries', function (Blueprint $table) {
        $table->id();
        $table->string('file_path'); // Lokasi file
        $table->string('file_type'); // 'image' atau 'video'
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_galleries');
    }
};
