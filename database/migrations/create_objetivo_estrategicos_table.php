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
        Schema::create('objetivos', function (Blueprint $table) {
            $table->mediumIncrements('idObjetivo');
            $table->string('codigo', 20)->unique()->nullable();
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->enum('tipo', [
                'Institucional',     // propio de la entidad
                'ODS',               // Objetivo de Desarrollo Sostenible
                'PND'                // Plan Nacional de Desarrollo
            ])->default('Institucional');
            $table->date('vigencia_desde')->nullable();
            $table->date('vigencia_hasta')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objetivos');
    }
};
