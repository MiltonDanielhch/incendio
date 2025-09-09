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
        Schema::create('grupos_etarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            // $table->string('rango_edad', 20)->comment('ej: 0-5, 6-12, 13-17');
            $table->integer('edad_minima')->nullable();
            $table->integer('edad_maxima')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['edad_minima', 'edad_maxima']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos_etarios');
    }
};
