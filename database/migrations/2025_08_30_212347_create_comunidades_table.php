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
        Schema::create('comunidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo_comunidad', ['urbana', 'rural', 'indigena']);
            $table->unsignedInteger('poblacion_aproximada')->nullable();
            $table->foreignId('municipio_id')->constrained('municipios')->onDelete('restrict');
            $table->foreignId('ubicacion_id')->nullable()->constrained('ubicaciones')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['municipio_id', 'tipo_comunidad']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comunidades');
    }
};
