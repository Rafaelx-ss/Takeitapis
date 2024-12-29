<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePatrocinadoresTable extends Migration
{
    public function up()
    {
        Schema::create('patrocinadores', function (Blueprint $table) {
            $table->bigIncrements('patrocinadorID');
            $table->unsignedBigInteger('usuarioID');
            $table->string('fotoPatrocinador', 255)->nullable();
            $table->string('nombrePatrocinador', 255);
            $table->string('representantePatrocinador', 255);
            $table->string('rfcPatrocinador', 255);
            $table->string('correoPatrocinador', 255);
            $table->string('telefonoPatrocinador', 50);
            $table->string('numeroRepresentantePatrocinador', 255);
            $table->boolean('activoPatrocinador')->default(true);
            $table->boolean('estadoPatrocinador')->default(true);
            $table->timestamps();

            $table->foreign('usuarioID')->references('usuarioID')->on('usuarios')->onUpdate('restrict')->onDelete('cascade');
        });

        DB::table('patrocinadores')->insert([
            ['usuarioID' => 1, 'fotoPatrocinador' => 'images/patrocinadores/20241226102649_cocacola_1.png', 'nombrePatrocinador' => 'Coca Cola', 'representantePatrocinador' => 'Juan Pérez', 'rfcPatrocinador' => 'COC-123456-789', 'correoPatrocinador' => 'coca@gmail.com', 'telefonoPatrocinador' => '1234567899', 'numeroRepresentantePatrocinador' => '1234567890', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 2, 'fotoPatrocinador' => 'images/patrocinadores/20241226102715_pepsi_2.png', 'nombrePatrocinador' => 'Pepsi', 'representantePatrocinador' => 'Pedro Pérez', 'rfcPatrocinador' => 'PEP-123456-789', 'correoPatrocinador' => 'pepsi@gmail.com', 'telefonoPatrocinador' => '1234567880', 'numeroRepresentantePatrocinador' => '1234567890', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 1, 'fotoPatrocinador' => 'images/patrocinadores/20241226102735_bimbo_3.png', 'nombrePatrocinador' => 'Bimbo', 'representantePatrocinador' => 'José Pérez', 'rfcPatrocinador' => 'BIM-123456-789', 'correoPatrocinador' => 'bimbo@gmail.com', 'telefonoPatrocinador' => '1234567790', 'numeroRepresentantePatrocinador' => '1234567890', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 2, 'fotoPatrocinador' => 'images/patrocinadores/20241226102752_sabritas_4.png', 'nombrePatrocinador' => 'Sabritas', 'representantePatrocinador' => 'Jorge Pérez', 'rfcPatrocinador' => 'SAB-123456-789', 'correoPatrocinador' => 'sabritas@gmail.com', 'telefonoPatrocinador' => '1234567800', 'numeroRepresentantePatrocinador' => '1234567890', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 1, 'fotoPatrocinador' => 'images/patrocinadores/20241226102809_adidas_6.png', 'nombrePatrocinador' => 'Adidas', 'representantePatrocinador' => 'Diego Ruiz', 'rfcPatrocinador' => 'ADI-321654-987', 'correoPatrocinador' => 'diego@adidas.com', 'telefonoPatrocinador' => '6789012345', 'numeroRepresentantePatrocinador' => '6789012345', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 2, 'fotoPatrocinador' => 'images/patrocinadores/20241226102900_nike_9.png', 'nombrePatrocinador' => 'Nike', 'representantePatrocinador' => 'Laura Pérez', 'rfcPatrocinador' => 'NIK-098765-432', 'correoPatrocinador' => 'laura@nike.com', 'telefonoPatrocinador' => '9012345678', 'numeroRepresentantePatrocinador' => '9012345678', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 1, 'fotoPatrocinador' => 'images/patrocinadores/20241226102825_tesla_7.png', 'nombrePatrocinador' => 'Tesla', 'representantePatrocinador' => 'María López', 'rfcPatrocinador' => 'TES-765432-109', 'correoPatrocinador' => 'maria@tesla.com', 'telefonoPatrocinador' => '7890123456', 'numeroRepresentantePatrocinador' => '7890123456', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 2, 'fotoPatrocinador' => 'images/patrocinadores/20241226102715_apple_3.png', 'nombrePatrocinador' => 'Apple', 'representantePatrocinador' => 'Ana Garcia', 'rfcPatrocinador' => 'APL-654321-789', 'correoPatrocinador' => 'ana@apple.com', 'telefonoPatrocinador' => '3456789012', 'numeroRepresentantePatrocinador' => '3456789012', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 1, 'fotoPatrocinador' => 'images/patrocinadores/20241226102951_xbox_12.png', 'nombrePatrocinador' => 'Xbox', 'representantePatrocinador' => 'Arturo Cabrera', 'rfcPatrocinador' => 'XBX-567890-123', 'correoPatrocinador' => 'arturo@xbox.com', 'telefonoPatrocinador' => '2345678901', 'numeroRepresentantePatrocinador' => '2345678901', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
            ['usuarioID' => 2, 'fotoPatrocinador' => 'images/patrocinadores/20241226103007_utm_13.png', 'nombrePatrocinador' => 'UTM', 'representantePatrocinador' => 'Carlos Hernandez', 'rfcPatrocinador' => 'UTM-098765-432', 'correoPatrocinador' => 'carlos@utm.edu', 'telefonoPatrocinador' => '3456789012', 'numeroRepresentantePatrocinador' => '3456789012', 'activoPatrocinador' => true, 'estadoPatrocinador' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('patrocinadores');
    }
}
