<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
       
         Schema::create('instituciones', function (Blueprint $table) {

            $table->id();

            // Datos básicos
            $table->string('nombre', 150);
            $table->string('siglas', 20)->nullable();
            $table->string('ruc', 13)->unique();              // RUC o NIT
            $table->string('tipo', 100)->nullable();          // Ministerio, GAD, Empresa Pública, etc.
            $table->string('zona', 50)->nullable();           // Zonal, Distrital, etc.

            // Estado (activo / inactivo)
            $table->boolean('estado')->default(true);

            // Auditoría simple
            //$table->foreignId('created_by')->nullable()
            //      ->constrained('users')->nullOnDelete();
            //$table->foreignId('updated_by')->nullable()
            //      ->constrained('users')->nullOnDelete();
            //$table->timestamps();
            //$table->softDeletes();
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        /* Schema::dropIfExists('instituciones');  // ← usa este si cambiaste el nombre */
        Schema::dropIfExists('entidades');          // ← usa este si mantienes "entidades"
    }
};
