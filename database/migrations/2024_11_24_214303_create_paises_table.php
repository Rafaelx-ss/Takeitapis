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
        Schema::create('paises', function (Blueprint $table) {
            $table->id('paisID');
            $table->string('nombrePais', 100);
            $table->boolean('activoPais')->default(true);
            $table->boolean('estadoPais')->default(true);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paises');
    }
};
