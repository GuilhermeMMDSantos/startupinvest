<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestidoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investidores', function (Blueprint $table) {
            $table->bigInteger('id_user')->unsigned();
            $table->string('nome');
            $table->string('sobrenome')->nullable();
            $table->string('nif')->nullable();
            $table->text('imgInvestidor')->nullable();
            $table->text('video_porque_investir');
            $table->timestamps();

            $table->primary('id_user');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investidores');
    }
}
