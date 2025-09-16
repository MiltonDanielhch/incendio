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
        Schema::create('reforestaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalogo_id')->constrained('catalogos')->onDelete('cascade')->comment('Especie de plantín');
            $table->integer('cantidad_plantines')->nullable();
            $table->decimal('area_reforestada_ha', 10, 2)->nullable();
            $table->date('fecha_reforestacion')->nullable();
            $table->decimal('supervivencia_estimada_porcentaje', 5, 2)->nullable();
            $table->foreignId('formulario_id')->constrained('formularios')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['fecha_reforestacion', 'formulario_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reforestaciones');
    }
};
