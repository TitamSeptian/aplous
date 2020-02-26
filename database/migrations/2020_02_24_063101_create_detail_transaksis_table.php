<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detail_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_transaksi');
            $table->unsignedInteger('id_paket');
            $table->double('qty');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')->on('tb_transaksi')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_paket')->on('tb_paket')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_detail_transaksi');
    }
}
