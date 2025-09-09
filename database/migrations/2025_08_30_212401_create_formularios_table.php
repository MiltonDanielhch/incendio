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
        Schema::create('formularios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_formulario')->unique()->nullable();
            $table->enum('estado', ['borrador', 'completado', 'validado', 'rechazado']);
            $table->date('fecha_llenado');
            $table->string('nombre_encuestador')->nullable();
            $table->string('contacto_encuestador')->nullable();
            $table->foreignId('comunidad_id')->constrained('comunidades')->onDelete('restrict');
            $table->foreignId('incendio_id')->constrained('incendios')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['fecha_llenado', 'comunidad_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formularios');
    }
};
