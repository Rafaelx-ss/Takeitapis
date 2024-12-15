<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEventosTable extends Migration
{
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->bigIncrements('eventoID');
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

        DB::table('eventos')->insert([
            ['patrocinadorID' => 1, 'categoriaID' => 1, 'subCategoriaID' => 1, 'nombreEvento' => 'Evento 1', 'lugarEvento' => 'Mérida', 'maximoParticipantesEvento' => '100', 'costoEvento' => '100.00', 'descripcionEvento' => 'Ejemplo de evento 1', 'cpEvento' => '20230', 'municioEvento' => 'Mérida', 'estadoID' => 31, 'direccionEvento' => 'Calle 60 #123 x 25 y 27', 'telefonoEvento' => '1234567890', 'fechaEvento' => '2024-11-24', 'horaEvento' => '10:00:00', 'duracionEvento' => '02:00:00', 'kitEvento' => 'Kit 1', 'activoEvento' => true, 'estadoEvento' => true, 'created_at' => now(), 'updated_at' => now()],
            ['patrocinadorID' => 2, 'categoriaID' => 2, 'subCategoriaID' => 4, 'nombreEvento' => 'Evento 2', 'lugarEvento' => 'Mérida', 'maximoParticipantesEvento' => '200', 'costoEvento' => '50.00', 'descripcionEvento' => 'Ejemplo de evento 2', 'cpEvento' => '20230', 'municioEvento' => 'Mérida', 'estadoID' => 31, 'direccionEvento' => 'Calle 60 #123 x 25 y 27', 'telefonoEvento' => '1234567890', 'fechaEvento' => '2024-11-24', 'horaEvento' => '20:00:00', 'duracionEvento' => '02:00:00', 'kitEvento' => 'Kit 2', 'activoEvento' => true, 'estadoEvento' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
