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
        Schema::create('entidades', function (Blueprint $table) {
            $table->id('idEntidad');
            $table->integer('codigo')->unique();
            $table->string('subSector');
            $table->string('nivelGobierno');
            $table->string('estado');
            $table->date('fechaCreacion');
            $table->date('fechaActualizacion')->nulleable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entidades');
    }
};
