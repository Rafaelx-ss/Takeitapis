<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('direccionesusuarios', function (Blueprint $table) {
            $table->id('direccionesUsuariosID');
            $table->unsignedBigInteger('usuarioID');
            $table->string('cpDireccion', 250);
            $table->string('municipioDireccion', 250);
            $table->unsignedBigInteger('estadoID');
            $table->string('direccion', 250);
            $table->timestamps(); // createdAt y updatedAt
            $table->boolean('activoDireccion')->default(true);
            $table->boolean('estadoDireccion')->default(true);

            // Llaves foráneas
            $table->foreign('usuarioID')->references('usuarioID')->on('usuarios');
            $table->foreign('estadoID')->references('estadoID')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccionesusuarios');
    }
};
