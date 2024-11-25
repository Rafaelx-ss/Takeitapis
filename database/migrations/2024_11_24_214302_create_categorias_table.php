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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('categoriaID');
            $table->string('nombreCategoria', 255);
            $table->string('descripcionCategoria', 255);
            $table->boolean('activoCategoria')->default(true);
            $table->boolean('estadoCategoria')->default(true);
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
        Schema::dropIfExists('categorias');
    }
};
