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
        Schema::create('afectados_incendios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_etario_id')->constrained('grupos_etarios')->onDelete('cascade');
            $table->integer('cantidad_afectados')->nullable();
            $table->integer('cantidad_fallecidos')->default(0);
            $table->integer('cantidad_lesionados')->default(0);
            $table->foreignId('formulario_id')->constrained('formularios')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['formulario_id', 'grupo_etario_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('afectados_incendios');
    }
};
