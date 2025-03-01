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
        Schema::create('praktik_kerja_lapangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('industri_id')->constrained('industries')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('industri_pembimbing_id')->constrained('industry_mentors')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['Dalam Proses', 'Selesai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('praktik_kerja_lapangans');
    }
};
