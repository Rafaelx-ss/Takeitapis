<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('usuarioID');
            $table->string('nombreUsuario', 250);
            $table->string('usuario', 250)->unique();
            $table->string('correoUsuario', 250)->unique();
            $table->string('contrasena', 400);
            $table->string('rolUsuario', 250);
            $table->string('telefonoUsuario', 50);
            $table->string('fechaNacimientoUsuario', 250)->nullable();
            $table->string('generoUsuario', 250)->nullable();
            $table->rememberToken(); // Token para recordar la sesión
            $table->boolean('activoUsuario')->default(true);
            $table->boolean('estadoUsuario')->default(true);
            $table->timestamps();
        });

        DB::table('usuarios')->insert([
            ['nombreUsuario' => 'Administrador', 'usuario' => 'admin', 'correoUsuario' => 'admin@gmail.com', 'contrasena' => bcrypt('admin'), 'rolUsuario' => 'Organizador', 'telefonoUsuario' => '1234567890', 'activoUsuario' => true, 'estadoUsuario' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreUsuario' => 'Usuario', 'usuario' => 'usuario', 'correoUsuario' => 'usuario@gmail.com', 'contrasena' => bcrypt('ususario'), 'rolUsuario' => 'Participante', 'telefonoUsuario' => '1234567890', 'activoUsuario' => true, 'estadoUsuario' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
