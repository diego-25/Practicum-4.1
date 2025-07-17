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
        Schema::create('planes', function (Blueprint $table) {
            $table->mediumIncrements('idPlan');
            $table->mediumInteger('idPrograma')->unsigned();    // FK
            $table->string('codigo', 20)->unique()->nullable();
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->date('vigencia_desde')->nullable();
            $table->date('vigencia_hasta')->nullable();
            $table->boolean('estado')->default(true);  // activo / inactivo
            $table->timestamps();
            //$table->foreign('idPrograma')->references('idPrograma')->on('programas_institucionales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan');
    }
};
