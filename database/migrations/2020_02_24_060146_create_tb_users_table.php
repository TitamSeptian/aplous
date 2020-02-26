<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 100);
            $table->string('username', 30)->unique();
            $table->text('password');
            $table->enum('role', ['owner', 'kasir', 'admin']);
            $table->unsignedInteger('id_outlet');
            $table->unsignedInteger('id_user');
            $table->timestamps();
            $table->foreign('id_user')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_user');
    }
}
