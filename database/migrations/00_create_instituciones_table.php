<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       
         Schema::create('instituciones', function (Blueprint $table) {
            $table->mediumIncrements('idInstitucion');
            $table->string('codigo', 20)->unique()->nullable();
            $table->string('nombre', 255);
            $table->string('siglas', 50)->nullable();
            $table->string('ruc', 10)->unique();
            $table->string('email', 255);
            $table->string('telefono', 10);
            $table->string('direccion', 255);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instituciones');
    }
};
