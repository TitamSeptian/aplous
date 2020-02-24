<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_paket', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_outlet');
            $table->unsignedInteger('id_jenis');
            $table->string('nama_paket', 100);
            $table->integer('harga', 11);
            $table->timestamps();

            $table->foreign('id_outlet')->on('tb_outlet')->references('id')->onUpdate('cascade');
            $table->foreign('id_jenis')->on('jenis')->references('id')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pakets');
    }
}
