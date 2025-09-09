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
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->id();
            // $table->decimal('latitud', 10, 8)->nullable();
            // $table->decimal('longitud', 11, 8)->nullable();
            $table->string('direccion')->nullable();
            $table->text('referencia')->nullable();
            // $table->geometry('coordenadas', 4326)->nullable();
            // $table->spatialIndex('coordenadas');
            $table->point('coordenadas', 4326);
            $table->spatialIndex('coordenadas');
            // $table->index(['latitud', 'longitud'], 'ubicaciones_lat_lon_idx');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicaciones');
    }
};
