<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalReportsTable extends Migration
{
    public function up()
    {
        Schema::create('final_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkl_id')->constrained('praktik_kerja_lapangan')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('students')->onDelete('cascade');
            $table->string('file');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('final_reports');
    }
}