<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->id();
            $table->string('fecha');
            $table->string('hora');
            $table->integer('num_comensales');
        
            //clave foránea:
            $table->unsignedBigInteger('idHorario');
            $table->foreign('idHorario')->references('id')->on('horario');
            $table->unsignedBigInteger('idMenu');
            $table->foreign('idMenu')->references('id')->on('menu');
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users');
            $table->string('idTarjeta');            
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
        Schema::dropIfExists('reserva');
    }
}
