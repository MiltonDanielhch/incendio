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
        Schema::create('incendios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_incendio')->unique()->nullable();
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();
            $table->text('causas_probables')->nullable();
            $table->enum('estado', ['activo', 'controlado', 'extinguido'])->default('controlado');
            $table->enum('nivel_gravedad', ['bajo', 'medio', 'alto', 'critico'])->default('medio');
            $table->decimal('area_afectada_ha', 10, 2)->nullable()->comment('Área total afectada');
            $table->foreignId('ubicacion_id')->nullable()->constrained('ubicaciones')->onDelete('restrict');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['fecha_inicio', 'estado']);
            $table->index('nivel_gravedad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incendios');
    }
};
