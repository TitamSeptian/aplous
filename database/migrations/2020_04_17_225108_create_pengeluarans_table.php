<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_outlet')->unsigned();
            $table->string('nama', 100);
            $table->string('bulan', 100);
            $table->integer('harga');
            $table->text('ket')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_outlet')->on('tb_outlet')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengeluaran');
    }
}
