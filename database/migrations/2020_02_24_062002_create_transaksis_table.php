<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_outlet'); //
            $table->string('kode_invoice', 100)->unique();
            $table->unsignedInteger('id_member'); //
            $table->dateTime('tgl');
            $table->dateTime('batas_waktu');
            $table->dateTime('tgl_bayar')->nullable();
            $table->integer('biaya_tambahan')->nullable();
            $table->double('diskon')->nullable();
            $table->integer('pajak')->nullable();
            $table->enum('status', ['baru', 'proses', 'selesai', 'diambil'])->default('baru');
            $table->enum('dibayar', ['dibayar', 'belum_dibayar'])->default('belum_dibayar');
            $table->unsignedInteger('id_user'); //
            $table->timestamps();

            $table->foreign('id_outlet')->on('tb_outlet')->references('id')->onUpdate('cascade');
            $table->foreign('id_member')->on('tb_member')->references('id')->onUpdate('cascade');
            $table->foreign('id_user')->on('tb_user')->references('id')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_transaksi');
    }
}
