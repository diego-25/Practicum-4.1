<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       
         Schema::create('instituciones', function (Blueprint $table) {
            $table->mediumIncrements('idInstitucion', true);
            $table->string('nombre', 255);
            $table->string('siglas', 50)->nullable();
            $table->string('ruc', 10)->unique();
            $table->string('email', 255);
            $table->string('telefono', 10);
            $table->string('direccion', 255);
            $table->boolean('estado')->default(true);
            //$table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            //$table->foreignId('updated_by')->nullable()
            //      ->constrained('users')->nullOnDelete();
            //$table->timestamps();
            //$table->softDeletes();
        });
    }
};
