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
        Schema::create('sectores_agricolas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalogo_id')->constrained('catalogos')->onDelete('cascade')->comment('Tipo de cultivo');
            $table->decimal('ha_afectadas', 15, 2)->default(0.00);
            $table->decimal('ha_perdidas', 15, 2)->default(0.00);
            $table->decimal('produccion_estimada_kg', 15, 2)->nullable();
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
        Schema::dropIfExists('sectores_agricolas');
    }
};
