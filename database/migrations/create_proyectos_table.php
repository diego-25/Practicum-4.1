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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->mediumIncrements('idProyecto');
            $table->unsignedMediumInteger('idPlan');
            $table->string('codigo', 20)->nullable()->unique();
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->decimal('monto_presupuesto', 14, 2)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->foreign('idPlan')->references('idPlan')->on('planes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
