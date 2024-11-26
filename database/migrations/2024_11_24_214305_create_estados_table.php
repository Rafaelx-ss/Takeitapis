<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEstadosTable extends Migration
{
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->bigIncrements('estadoID');
            $table->string('nombreEstado', 100);
            $table->unsignedBigInteger('paisID');
            $table->boolean('activoEstado')->default(true);
            $table->boolean('estadoEstado')->default(true);
            $table->timestamps();

            $table->foreign('paisID')->references('paisID')->on('paises')->onUpdate('restrict')->onDelete('cascade');
        });

        DB::table('estados')->insert([
            ['nombreEstado' => 'Aguascalientes', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Baja California', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Baja California Sur', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Campeche', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Chiapas', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Chihuahua', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Coahuila', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Colima', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Ciudad de México', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Durango', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Guanajuato', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Guerrero', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Hidalgo', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Jalisco', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Estado de México', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Michoacán', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Morelos', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Nayarit', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Nuevo León', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Oaxaca', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Puebla', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Querétaro', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Quintana Roo', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'San Luis Potosí', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Sinaloa', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Sonora', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Tabasco', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Tamaulipas', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Tlaxcala', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Veracruz', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Yucatán', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombreEstado' => 'Zacatecas', 'paisID' => 1, 'activoEstado' => true, 'estadoEstado' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('estados');
    }
}
