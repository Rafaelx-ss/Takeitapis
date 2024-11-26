<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreatePaisesTable extends Migration
{
    public function up()
    {
        Schema::create('paises', function (Blueprint $table) {
            $table->bigIncrements('paisID');
            $table->string('nombrePais', 100);
            $table->boolean('activoPais')->default(true);
            $table->boolean('estadoPais')->default(true);
            $table->timestamps();
        });

        DB::table('paises')->insert([
            ['nombrePais' => 'México', 'activoPais' => true, 'estadoPais' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
    public function down()
    {
        Schema::dropIfExists('paises');
    }
}
