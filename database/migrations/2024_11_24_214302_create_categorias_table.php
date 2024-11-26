<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCategoriasTable extends Migration
{
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->bigIncrements('categoriaID');
            $table->string('nombreCategoria', 255);
            $table->string('descripcionCategoria', 255);
            $table->boolean('activoCategoria')->default(true);
            $table->boolean('estadoCategoria')->default(true);
            $table->timestamps();
        });

        DB::table('categorias')->insert([
            ['nombreCategoria' => 'Deportes', 'descripcionCategoria' => 'Eventos y competencias deportivas de distintos niveles y disciplinas', 'activoCategoria' => true, 'estadoCategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreCategoria' => 'Arte', 'descripcionCategoria' => 'Eventos artísticos como exposiciones, presentaciones y talleres', 'activoCategoria' => true, 'estadoCategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreCategoria' => 'Tecnología', 'descripcionCategoria' => 'Conferencias, talleres y exposiciones de innovación tecnológica', 'activoCategoria' => true, 'estadoCategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreCategoria' => 'Negocios', 'descripcionCategoria' => 'Seminarios, conferencias y encuentros de negocios y networking', 'activoCategoria' => true, 'estadoCategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreCategoria' => 'Moda', 'descripcionCategoria' => 'Desfiles, lanzamientos y eventos de la industria de la moda', 'activoCategoria' => true, 'estadoCategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreCategoria' => 'Música', 'descripcionCategoria' => 'Conciertos, festivales y otros eventos musicales', 'activoCategoria' => true, 'estadoCategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreCategoria' => 'Cultura', 'descripcionCategoria' => 'Eventos culturales, exposiciones y actividades para promover la cultura', 'activoCategoria' => true, 'estadoCategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreCategoria' => 'Educación', 'descripcionCategoria' => 'Seminarios, talleres y conferencias de carácter educativo y formativo', 'activoCategoria' => true, 'estadoCategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreCategoria' => 'Gastronomía', 'descripcionCategoria' => 'Eventos culinarios, degustaciones y festivales gastronómicos', 'activoCategoria' => true, 'estadoCategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreCategoria' => 'Bienestar', 'descripcionCategoria' => 'Eventos de salud, fitness y actividades de bienestar', 'activoCategoria' => true, 'estadoCategoria' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

    }

    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}
