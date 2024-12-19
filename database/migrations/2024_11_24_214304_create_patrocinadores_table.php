<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePatrocinadoresTable extends Migration
{
    public function up()
    {
        Schema::create('patrocinadores', function (Blueprint $table) {
            $table->bigIncrements('patrocinadorID');
            $table->unsignedBigInteger('usuarioID');
            $table->binary('fotoPatrocinador')->nullable();
            $table->string('nombrePatrocinador', 255);
            $table->string('representantePatrocinador', 255);
            $table->string('rfcPatrocinador', 255);
            $table->string('correoPatrocinador', 255);
            $table->string('telefonoPatrocinador', 50);
            $table->string('numeroRepresentantePatrocinador', 255);
            $table->boolean('activoPatrocinador')->default(true);
            $table->boolean('estadoPatrocinador')->default(true);
            $table->timestamps();

            $table->foreign('usuarioID')->references('usuarioID')->on('usuarios')->onUpdate('restrict')->onDelete('cascade');
        });

        DB::table('patrocinadores')->insert([
            ['usuarioID' => 1,'fotoPatrocinador' => null, 'nombrePatrocinador' => 'Coca Cola', 'representantePatrocinador' => 'Juan Pérez', 'rfcPatrocinador' => 'COC-123456-789', 'correoPatrocinador' => 'coca@gmail.com', 'telefonoPatrocinador' => '1234567890', 'numeroRepresentantePatrocinador' => '1234567890', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 1,'fotoPatrocinador' => null, 'nombrePatrocinador' => 'Pepsi', 'representantePatrocinador' => 'Pedro Pérez', 'rfcPatrocinador' => 'PEP-123456-789', 'correoPatrocinador' => 'pepsi@gmail.com', 'telefonoPatrocinador' => '1234567890', 'numeroRepresentantePatrocinador' => '1234567890', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 1,'fotoPatrocinador' => null, 'nombrePatrocinador' => 'Bimbo', 'representantePatrocinador' => 'José Pérez', 'rfcPatrocinador' => 'BIM-123456-789', 'correoPatrocinador' => 'bimbo@gmail.com', 'telefonoPatrocinador' => '1234567890', 'numeroRepresentantePatrocinador' => '1234567890', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 1,'fotoPatrocinador' => null, 'nombrePatrocinador' => 'Sabritas', 'representantePatrocinador' => 'Jorge Pérez', 'rfcPatrocinador' => 'SAB-123456-789', 'correoPatrocinador' => 'sabritas@gmail.com', 'telefonoPatrocinador' => '1234567890', 'numeroRepresentantePatrocinador' => '1234567890', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('patrocinadores');
    }
}
