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
            $table->string('email', 250)->unique();
            $table->string('password', 400);
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
            ['nombreUsuario' => 'Administrador', 'usuario' => 'admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('admin123'), 'rolUsuario' => 'Organizador', 'telefonoUsuario' => '1234567890', 'fechaNacimientoUsuario' => '01/01/2000', 'generoUsuario' => 'MASCULINO', 'activoUsuario' => true, 'estadoUsuario' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreUsuario' => 'Usuario', 'usuario' => 'usuario', 'email' => 'usuario@gmail.com', 'password' => bcrypt('usuario'), 'rolUsuario' => 'Participante', 'telefonoUsuario' => '1234567890', 'fechaNacimientoUsuario' => '01/01/1998', 'generoUsuario' => 'FEMENINO', 'activoUsuario' => true, 'estadoUsuario' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
