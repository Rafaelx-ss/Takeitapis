<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarioseventos', function (Blueprint $table) {
            $table->bigincrements('usuarioeventoID');
            $table->unsignedBigInteger('usuarioID');
            $table->unsignedBigInteger('eventoID');
            $table->timestamps();

            $table->foreign('usuarioID')->references('usuarioID')->on('usuarios')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('eventoID')->references('eventoID')->on('eventos')->onUpdate('restrict')->onDelete('cascade');
        });

        DB::table('usuarioseventos')->insert([
            ['usuarioID' => 1, 'eventoID' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 1, 'eventoID' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarioseventos');
    }
};
