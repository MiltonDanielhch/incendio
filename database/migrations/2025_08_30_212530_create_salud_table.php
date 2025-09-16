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
        Schema::create('salud', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_etario_id')->constrained('grupos_etarios')->onDelete('cascade');
            $table->foreignId('catalogo_id')->constrained('catalogos')->onDelete('cascade')->comment('Enfermedad o condición de salud');
            $table->foreignId('formulario_id')->constrained('formularios')->onDelete('cascade');
            $table->integer('cantidad_enfermos')->default(0);
            $table->integer('gravedad_promedio')->nullable()->comment('Escala del 1 al 5');
            $table->text('tratamiento_requerido')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['formulario_id', 'catalogo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salud');
    }
};
