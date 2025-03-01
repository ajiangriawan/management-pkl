<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLettersTable extends Migration
{
    public function up()
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkl_id')->constrained('praktik_kerja_lapangan')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('students')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['Diajukan', 'Disetujui', 'Ditolak']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('letters');
    }
}