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
        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo', 10)->nullable();
            $table->string('nombre_alcalde')->nullable();
            $table->unsignedInteger('poblacion_total')->default(0);
            $table->decimal('area_km2', 10, 2)->nullable();
            $table->foreignId('provincia_id')->constrained('provincias')->onDelete('restrict');
            $table->foreignId('ubicacion_id')->nullable()->constrained('ubicaciones')->onDelete('restrict');
            $table->unique(['nombre', 'provincia_id']);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};
