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
        Schema::create('reportes_comunitarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulario_id')->constrained('formularios')->onDelete('cascade');
            $table->integer('incendios_registrados')->nullable();
            $table->integer('incendios_activos')->nullable();
            $table->text('necesidades')->nullable();
            $table->text('ayuda_recibida')->nullable();
            $table->integer('num_familias_afectadas')->nullable();
            $table->integer('num_familias_damnificadas')->nullable();
            $table->integer('num_personas_evacuadas')->nullable();
            $table->text('vias_acceso_afectadas')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_comunitarios');
    }
};
