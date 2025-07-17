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
        Schema::create('institucion_user', function (Blueprint $table) {
            $table->mediumInteger('idInstitucion')->unsigned();
            $table->mediumInteger('idUsuario')->unsigned();
            $table->primary(['idInstitucion','idUsuario']);
            $table->foreign('idInstitucion')->references('idInstitucion')->on('instituciones')->onDelete('cascade');
            $table->foreign('idUsuario')->references('idUsuario')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institucion_user');
    }
};
