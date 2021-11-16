<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengantarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengantars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->string('pengirim');
            $table->string('kepada')->nullable();
            $table->text('isi')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_surat');
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
        Schema::dropIfExists('pengantars');
    }
}
