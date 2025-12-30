<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  // database/migrations/xxxx_create_photo_gallery_tables.php
public function up()
{
    // Tabel Foto
    Schema::create('photos', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('image_path'); // Path file foto (bisa dikasih watermark nanti)
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });

    // Tabel Order
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->text('photo_ids'); // Simpan ID foto yg dibeli (misal: "1,4,5")
        $table->decimal('total_price', 10, 2);
        $table->enum('status', ['pending', 'paid'])->default('pending');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_gallery_tables');
    }
};
