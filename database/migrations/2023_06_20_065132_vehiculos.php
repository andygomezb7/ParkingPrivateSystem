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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type');
            $table->string('placa');
            $table->string('marca')->nullable();
            $table->string('modelo_linea')->nullable();
            $table->timestamp('hora_entrada')->nullable();
            $table->timestamp('hora_salida')->nullable();
            $table->integer('horasacumuladas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
