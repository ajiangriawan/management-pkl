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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkl_id')->constrained('praktik_kerja_lapangan')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('students')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('lokasi');
            $table->string('selfie');
            $table->enum('jenis_absensi', ['Masuk', 'Pulang']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_pkls');
    }
};
