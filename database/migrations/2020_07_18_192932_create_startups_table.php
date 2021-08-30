<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStartupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('startups', function (Blueprint $table) {
            $table->bigInteger('id_user')->unsigned();
            $table->string('nome')->unique();
            $table->bigInteger('setor_atividade')->unsigned();
            $table->bigInteger('fase_desenvolvimento')->unsigned();
            $table->bigInteger('tipobusness')->unsigned()->default(1);
            $table->text('video_produto');
            $table->text('pitch_elevator');
            $table->text('img')->nullable();
            $table->timestamps();
            
            $table->primary('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('setor_atividade')->references('id')->on('setores');
            $table->foreign('fase_desenvolvimento')->references('id')->on('fases');
            $table->foreign('tipobusness')->references('id')->on('tipo_busnesses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('startups');
    }
}
