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
        Schema::create('estados', function (Blueprint $table) {
            $table->id('estadoID');
            $table->string('nombreEstado', 100);
            $table->unsignedBigInteger('paisID');
            $table->boolean('activoEstado')->default(true);
            $table->boolean('estadoEstado')->default(true);

            // Llave foránea
            $table->foreign('paisID')->references('paisID')->on('paises');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
