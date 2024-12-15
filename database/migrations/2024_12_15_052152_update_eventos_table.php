<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['patrocinadorid']);
            $table->dropColumn('patrocinadorID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->unsignedBigInteger('patrocinadorID');
            $table->foreign('patrocinadorID')->references('patrocinadorID')->on('patrocinadores')->onUpdate('restrict')->onDelete('cascade');
        });
    }
};
