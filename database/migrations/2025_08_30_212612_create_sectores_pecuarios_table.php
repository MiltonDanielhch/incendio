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
        Schema::create('sectores_pecuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalogo_id')->constrained('catalogos')->onDelete('cascade')->comment('Tipo de especie');
            $table->integer('numero_animales_afectados')->default(0);
            $table->integer('numero_animales_fallecidos')->nullable();
            $table->integer('numero_animales_evacuados')->nullable();
            $table->decimal('valor_estimado_perdida', 15, 2)->nullable();
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
        Schema::dropIfExists('sectores_pecuarios');
    }
};
