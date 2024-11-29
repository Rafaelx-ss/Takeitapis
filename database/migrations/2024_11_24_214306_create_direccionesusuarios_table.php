<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDireccionesUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('direccionesusuarios', function (Blueprint $table) {
            $table->bigIncrements('direccionesUsuariosID');
            $table->unsignedBigInteger('usuarioID');
            $table->string('cpDireccion', 250);
            $table->string('municipioDireccion', 250);
            $table->unsignedBigInteger('estadoID');
            $table->string('direccion', 250);
            $table->boolean('activoDireccion')->default(true);
            $table->boolean('estadoDireccion')->default(true);
            $table->timestamps();

            $table->foreign('usuarioID')->references('usuarioID')->on('usuarios')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('estadoID')->references('estadoID')->on('estados')->onUpdate('restrict')->onDelete('cascade');
        });

        DB::table('direccionesusuarios')->insert([
            ['usuarioID' => 1, 'cpDireccion' => '20230', 'municipioDireccion' => 'Mérida', 'estadoID' => 31, 'direccion' => 'Calle 60 #123 x 25 y 27', 'activoDireccion' => true, 'estadoDireccion' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 2, 'cpDireccion' => '20230', 'municipioDireccion' => 'Mérida', 'estadoID' => 31, 'direccion' => 'Calle 60 #123 x 25 y 27', 'activoDireccion' => true, 'estadoDireccion' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('direccionesusuarios');
    }
}

