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
        Schema::create('educacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalogo_id')->constrained('catalogos')->onDelete('cascade')->comment('Institución educativa');
            $table->foreignId('modalidad_educacion_id')->constrained('catalogos')->onDelete('cascade')->comment('Modalidad educativa');
            $table->integer('num_estudiantes')->nullable();
            $table->integer('num_estudiantes_afectados')->nullable();
            $table->integer('dias_clase_perdidos')->nullable();
            $table->foreignId('formulario_id')->constrained('formularios')->onDelete('cascade');
            $table->timestamps();
            $table->index(['formulario_id', 'catalogo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educacion');
    }
};
