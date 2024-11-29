<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatrocinadoresTable extends Migration
{
    public function up()
    {
        Schema::create('patrocinadores', function (Blueprint $table) {
            $table->bigIncrements('patrocinadorID');
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
        });
    }

    public function down()
    {
        Schema::dropIfExists('patrocinadores');
    }
}
