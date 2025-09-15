<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Rellenar los NULL con un punto “vacío” (0°, 0°)
        DB::table('ubicaciones')
          ->whereNull('coordenadas')
          ->update(['coordenadas' => DB::raw("ST_GeomFromText('POINT(0 0)', 4326)")]);

        // 2. Hacer la columna NOT NULL
        Schema::table('ubicaciones', function (Blueprint $table) {
            $table->point('coordenadas', 4326)->nullable(false)->change();
        });

        // 3. Crear el índice espacial (si aún no existe)
        Schema::table('ubicaciones', function (Blueprint $table) {
            $table->spatialIndex('coordenadas');
        });
    }

    public function down()
    {
        // revertir: dejar nullable y quitar el índice
        Schema::table('ubicaciones', function (Blueprint $table) {
            $table->dropSpatialIndex(['coordenadas']);
            $table->point('coordenadas', 4326)->nullable()->change();
        });
    }
};
