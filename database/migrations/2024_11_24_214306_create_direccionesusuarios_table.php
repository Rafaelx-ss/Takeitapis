<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionesUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('direccionesusuarios', function (Blueprint $table) {
            $table->bigIncrements('direccionesUsuariosID');
            $table->unsignedBigInteger('usuarioID');
            $table->string('cpDireccion', 250);
            $table->string('municipioDireccion', 250);
            $table->unsignedBigInteger('estadoID');
            $table->string('direccion', 250);
            $table->boolean('activoDireccion')->default(true);
            $table->boolean('estadoDireccion')->default(true);
            $table->timestamps();

            $table->foreign('usuarioID')->references('usuarioID')->on('usuarios')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('estadoID')->references('estadoID')->on('estados')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('direccionesusuarios');
    }
}
