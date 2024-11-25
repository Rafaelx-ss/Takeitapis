<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('usuarioID');
            $table->string('nombreUsuario', 250);
            $table->string('usuario', 250)->unique();
            $table->string('correoUsuario', 250)->unique();
            $table->string('contrasena', 400);
            $table->string('rolUsuario', 250);
            $table->string('telefonoUsuario', 250);
            $table->string('fechaNacimientoUsuario', 250)->nullable();
            $table->string('generoUsuario', 250)->nullable();
            $table->timestamps();
            $table->boolean('activoUsuario')->default(true);
            $table->boolean('estadoUsuario')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
