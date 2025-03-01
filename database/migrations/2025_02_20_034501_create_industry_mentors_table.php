<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateIndustryMentorsTable extends Migration
{
    public function up()
    {
        Schema::create('industry_mentors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industri_id')->constrained('industries')->onDelete('cascade');
            $table->string('email')->unique();
            $table->string('nama');
            $table->string('telepon', 15);
            $table->text('alamat');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('industry_mentors');
    }
}
