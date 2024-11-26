<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSubcategoriasTable extends Migration
{
    public function up()
    {
        Schema::create('subcategorias', function (Blueprint $table) {
            $table->bigIncrements('subcategoriaID');
            $table->unsignedBigInteger('categoriaID');
            $table->string('nombreSubcategoria', 255);
            $table->string('descripcionSubcategoria', 255);
            $table->boolean('activoSubcategoria')->default(true);
            $table->boolean('estadoSubcategoria')->default(true);
            $table->timestamps();

            $table->foreign('categoriaID')->references('categoriaID')->on('categorias')->onUpdate('restrict')->onDelete('cascade');
        });

        DB::table('subcategorias')->insert([
            // Subcategorías de 'Deportes'
            ['categoriaID' => 1, 'nombreSubcategoria' => 'Fútbol', 'descripcionSubcategoria' => 'Competencias y torneos de fútbol', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 1, 'nombreSubcategoria' => 'Baloncesto', 'descripcionSubcategoria' => 'Torneos y partidos de baloncesto', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 1, 'nombreSubcategoria' => 'Maratón', 'descripcionSubcategoria' => 'Carreras de larga distancia y maratones', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],

            // Subcategorías de 'Arte'
            ['categoriaID' => 2, 'nombreSubcategoria' => 'Pintura', 'descripcionSubcategoria' => 'Exposiciones y talleres de pintura', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 2, 'nombreSubcategoria' => 'Escultura', 'descripcionSubcategoria' => 'Eventos relacionados con el arte de la escultura', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 2, 'nombreSubcategoria' => 'Teatro', 'descripcionSubcategoria' => 'Obras de teatro y presentaciones escénicas', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],

            // Subcategorías de 'Tecnología'
            ['categoriaID' => 3, 'nombreSubcategoria' => 'Inteligencia Artificial', 'descripcionSubcategoria' => 'Charlas y seminarios sobre IA', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 3, 'nombreSubcategoria' => 'Blockchain', 'descripcionSubcategoria' => 'Conferencias y talleres sobre tecnología blockchain', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 3, 'nombreSubcategoria' => 'Desarrollo Web', 'descripcionSubcategoria' => 'Talleres y eventos sobre desarrollo web', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],

            // Subcategorías de 'Negocios'
            ['categoriaID' => 4, 'nombreSubcategoria' => 'Emprendimiento', 'descripcionSubcategoria' => 'Eventos orientados a startups y emprendedores', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 4, 'nombreSubcategoria' => 'Finanzas', 'descripcionSubcategoria' => 'Seminarios sobre finanzas y contabilidad', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],

            // Subcategorías de 'Moda'
            ['categoriaID' => 5, 'nombreSubcategoria' => 'Desfiles de Moda', 'descripcionSubcategoria' => 'Eventos de desfiles y nuevas colecciones', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 5, 'nombreSubcategoria' => 'Diseño Textil', 'descripcionSubcategoria' => 'Talleres y seminarios sobre diseño textil', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],

            // Subcategorías de 'Música'
            ['categoriaID' => 6, 'nombreSubcategoria' => 'Conciertos de Rock', 'descripcionSubcategoria' => 'Conciertos de música rock', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 6, 'nombreSubcategoria' => 'Música Clásica', 'descripcionSubcategoria' => 'Conciertos de música clásica y recitales', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],

            // Subcategorías de 'Cultura'
            ['categoriaID' => 7, 'nombreSubcategoria' => 'Danza', 'descripcionSubcategoria' => 'Eventos culturales de danza', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 7, 'nombreSubcategoria' => 'Literatura', 'descripcionSubcategoria' => 'Lecturas de libros y festivales literarios', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],

            // Subcategorías de 'Educación'
            ['categoriaID' => 8, 'nombreSubcategoria' => 'Cursos en Línea', 'descripcionSubcategoria' => 'Cursos y talleres educativos en línea', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 8, 'nombreSubcategoria' => 'Capacitación Profesional', 'descripcionSubcategoria' => 'Eventos y talleres de capacitación', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],

            // Subcategorías de 'Gastronomía'
            ['categoriaID' => 9, 'nombreSubcategoria' => 'Cata de Vinos', 'descripcionSubcategoria' => 'Degustaciones de vinos y catas', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 9, 'nombreSubcategoria' => 'Clases de Cocina', 'descripcionSubcategoria' => 'Clases magistrales de cocina', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],

            // Subcategorías de 'Bienestar'
            ['categoriaID' => 10, 'nombreSubcategoria' => 'Yoga', 'descripcionSubcategoria' => 'Clases y talleres de yoga', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
            ['categoriaID' => 10, 'nombreSubcategoria' => 'Meditación', 'descripcionSubcategoria' => 'Sesiones de meditación y mindfulness', 'activoSubcategoria' => true, 'estadoSubcategoria' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('subcategorias');
    }
}
