<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutasis', function (Blueprint $table) {
            $table->id();
            $table->string('pengirim');
            $table->string('nomor_induk');
            $table->string('pangkat')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alasan')->nullable();
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
        Schema::dropIfExists('mutasis');
    }
}
