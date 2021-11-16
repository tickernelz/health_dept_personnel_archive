<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMendudukijabatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mendudukijabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->nullable();
            $table->string('nama_pengirim');
            $table->string('nip_pengirim')->nullable();
            $table->string('pangkat_pengirim')->nullable();
            $table->string('jabatan_pengirim');
            $table->string('nama_penerima');
            $table->string('nip_penerima')->nullable();
            $table->string('pangkat_penerima')->nullable();
            $table->string('jabatan_penerima');
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
        Schema::dropIfExists('mendudukijabatans');
    }
}
