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
        Schema::create('eraports', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Siswa)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // --- ASPEK FISIK (0-100) ---
            $table->integer('agility')->default(0);
            $table->integer('speed')->default(0);
            $table->integer('stamina')->default(0);
            $table->integer('strength')->default(0);

            // --- ASPEK TEKNIK (0-100) ---
            $table->integer('passing')->default(0);
            $table->integer('dribbling')->default(0);
            $table->integer('shooting')->default(0);
            $table->integer('defending')->default(0);

            // --- CATATAN & EVALUASI ---
            $table->text('strength_note')->nullable(); // Kelebihan
            $table->text('weakness_note')->nullable(); // Kekurangan
            $table->text('general_note')->nullable();  // Catatan Umum

            // --- SKOR AKHIR ---
            // Menggunakan decimal agar bisa menyimpan koma (contoh: 85.5)
            $table->decimal('average_score', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eraports');
    }
};
