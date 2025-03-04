<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyJournalsTable extends Migration
{
    public function up()
    {
        Schema::create('daily_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkl_id')->constrained('praktik_kerja_lapangans')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('isi');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_journals');
    }
}
