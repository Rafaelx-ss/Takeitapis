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
        Schema::create('subcategorias', function (Blueprint $table) {
            $table->id('subcategoriaID');
            $table->string('nombreSubcategoria', 255);
            $table->string('descripcionSubcategoria', 255);
            $table->boolean('activoSubcategoria')->default(true);
            $table->boolean('estadoSubcategoria')->default(true);
            $table->timestamps(); // createdAt y updatedAt
            $table->unsignedBigInteger('createdById');
            $table->unsignedBigInteger('updatedById')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategorias');
    }
};
