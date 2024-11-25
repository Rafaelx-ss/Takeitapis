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
        Schema::create('patrocinadores', function (Blueprint $table) {
            $table->id('patrocinadorID');
            $table->binary('fotoPatrocinador')->nullable();
            $table->string('nombrePatrocinador', 255);
            $table->string('representantePatrocinador', 255);
            $table->string('rfcPatrocinador', 255);
            $table->string('correoPatrocinador', 255);
            $table->string('telefonoPatrocinador', 255);
            $table->string('numeroRepresentantePatrocinador', 255);
            $table->timestamps(); // createdAt y updatedAt
            $table->unsignedBigInteger('createdById');
            $table->unsignedBigInteger('updatedById')->nullable();
            $table->boolean('activoPatrocinador')->default(true);
            $table->boolean('estadoPatrocinador')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrocinadores');
    }
};
