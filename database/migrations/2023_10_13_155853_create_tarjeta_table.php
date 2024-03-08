<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarjetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('tarjeta', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('numero');
        $table->integer('cvv');
        $table->integer('fecha_caducidad');
        $table->unsignedBigInteger('idUser');
        $table->foreign('idUser')->references('id')->on('users');
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
        Schema::dropIfExists('tarjeta');
    }
}
