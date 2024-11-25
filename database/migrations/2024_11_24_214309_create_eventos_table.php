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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id('eventosID');
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
            $table->string('estadoID', 255);
            $table->string('direccionEvento', 255);
            $table->string('telefonoEvento', 255);
            $table->string('fechaEvento', 255);
            $table->string('horaEvento', 255);
            $table->string('duracionEvento', 255);
            $table->string('kitEvento', 255)->nullable();
            $table->timestamps(); // createdAt y updatedAt
            $table->boolean('activoEvento')->default(true);
            $table->boolean('estadoEvento')->default(true);

            // Llaves foráneas
            $table->foreign('patrocinadorID')->references('patrocinadorID')->on('patrocinadores');
            $table->foreign('categoriaID')->references('categoriaID')->on('categorias');
            $table->foreign('subCategoriaID')->references('subcategoriaID')->on('subcategorias');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
