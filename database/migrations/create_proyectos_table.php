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
            //PK
            $table->mediumIncrements('idProyecto');
            //FK
            $table->unsignedMediumInteger('idPlan');
            $table->unsignedMediumInteger('idPrograma');
            //Atributos
            $table->string('codigo', 20)->nullable()->unique();
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->decimal('monto_presupuesto', 14, 2)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            //foraneas
            $table->foreign('idPlan')->references('idPlan')->on('planes')->onDelete('cascade');
            $table->foreign('idPrograma')->references('idPrograma')->on('programas')->onDelete('cascade');
            //indice compuesto
            $table->index(['idPlan', 'idPrograma'],'idx_plan_programa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropForeign(['idPlan']);
            $table->dropForeign(['idPrograma']);
            $table->dropIndex('idx_plan_programa');
        });
    }
};
