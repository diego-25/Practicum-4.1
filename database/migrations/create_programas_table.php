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
        Schema::create('programas', function (Blueprint $table) {
            $table->mediumIncrements('idPrograma');
            $table->unsignedMediumInteger('idObjetivo');
            $table->string('codigo', 20)->nullable()->unique();
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->date('vigencia_desde')->nullable();
            $table->date('vigencia_hasta')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->foreign('idObjetivo')->references('idObjetivo')->on('objetivos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programas');
    }
};
