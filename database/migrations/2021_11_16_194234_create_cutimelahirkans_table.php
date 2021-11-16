<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCutimelahirkansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cutimelahirkans', function (Blueprint $table) {
            $table->id();
            $table->string('pengirim');
            $table->string('nomor_induk');
            $table->string('divisi')->nullable();
            $table->string('jabatan')->nullable();
            $table->date('tanggal_surat');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('file')->nullable();
            $table->string('operator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cutimelahirkans');
    }
}
