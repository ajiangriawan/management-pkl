<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->bigInteger('nisn')->unique();
            $table->string('nama');
            $table->string('telepon', 15);
            $table->string('kelas', 15);
            $table->text('alamat');
            $table->enum('status', ['Active', 'Deactive']);        
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
