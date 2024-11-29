<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->bigIncrements('eventosID');
            $table->unsignedBigInteger('patrocinadorID');
            $table->unsignedBigInteger('categoriaID');
            $table->unsignedBigInteger('subCategoriaID');
            $table->string('nombreEvento', 255);
            $table->string('lugarEvento', 255);
            $table->string('maximoParticipantesEvento', 255)->nullable();
            $table->decimal('costoEvento', 10, 2)->nullable();
            $table->string('descripcionEvento', 255)->nullable();
            $table->string('cpEvento', 255);
            $table->string('municioEvento', 255);
            $table->unsignedBigInteger('estadoID');
            $table->string('direccionEvento', 255);
            $table->string('telefonoEvento', 255);
            $table->string('fechaEvento', 255);
            $table->string('horaEvento', 255);
            $table->string('duracionEvento', 255);
            $table->string('kitEvento', 255)->nullable();
            $table->boolean('activoEvento')->default(true);
            $table->boolean('estadoEvento')->default(true);
            $table->timestamps();

            $table->foreign('patrocinadorID')->references('patrocinadorID')->on('patrocinadores')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('categoriaID')->references('categoriaID')->on('categorias')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('subCategoriaID')->references('subcategoriaID')->on('subcategorias')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('estadoID')->references('estadoID')->on('estados')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
