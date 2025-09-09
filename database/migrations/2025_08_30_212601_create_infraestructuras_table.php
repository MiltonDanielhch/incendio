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
        Schema::create('infraestructuras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalogo_id')->constrained('catalogos')->onDelete('cascade')->comment('Tipo de infraestructura');
            $table->integer('cantidad_afectadas')->nullable();
            $table->integer('cantidad_destruidas')->nullable();
            $table->decimal('valor_estimado_perdida', 15, 2)->nullable();
            $table->text('descripcion_dano')->nullable();
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
        Schema::dropIfExists('infraestructuras');
    }
};
