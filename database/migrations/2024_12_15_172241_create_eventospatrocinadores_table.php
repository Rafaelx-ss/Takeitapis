<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eventospatrocinadores', function (Blueprint $table) {
            $table->bigIncrements('eventopatrocinadorID');
            $table->unsignedBigInteger('patrocinadorID');
            $table->unsignedBigInteger('eventoID');
            $table->timestamps();

            $table->foreign('patrocinadorID')->references('patrocinadorID')->on('patrocinadores')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('eventoID')->references('eventoID')->on('eventos')->onUpdate('restrict')->onDelete('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventospatrocinadores');
    }
};
