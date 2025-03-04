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
        Schema::create('attendances', function (Blueprint $table) { // Nama tabel disesuaikan ke "attendances"
            $table->id();
            $table->foreignId('pkl_id')->constrained('praktik_kerja_lapangans')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('students')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu')->nullable(); // Waktu masuk
            $table->decimal('latitude', 10, 7); // Menyimpan lokasi dengan koordinat
            $table->decimal('longitude', 10, 7);
            $table->string('selfie'); // Path foto selfie
            $table->enum('jenis_absensi', ['Masuk', 'Pulang']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances'); // Nama tabel sudah sesuai
    }
};
