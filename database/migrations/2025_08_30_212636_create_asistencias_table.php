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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->text('actividades')->nullable();
            $table->integer('cantidad_beneficiarios')->nullable();
            $table->date('fecha_asistencia')->nullable();
            $table->string('organizacion_proveedora')->nullable();
            $table->foreignId('tipo_asistencia_id')->constrained('catalogos')->onDelete('cascade');
            $table->decimal('valor_asistencia', 15, 2)->nullable();
            $table->foreignId('formulario_id')->constrained('formularios')->onDelete('cascade');
            $table->timestamps();
            $table->index(['fecha_asistencia', 'formulario_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
