<?php

namespace Database\Seeders;

use App\Models\SectorPecuario;
use App\Models\Formulario;
use App\Models\Catalogo;
use Illuminate\Database\Seeder;

class SectorPecuarioSeeder extends Seeder
{
    public function run(): void
    {
        $formularios = Formulario::all();
        $especies    = Catalogo::where('tipo', 'tipo_especie')->get();

        foreach ($formularios as $formulario) {
            foreach ($especies as $especie) {
                $afectados = rand(0, 100);
                $fallecidos = $afectados ? rand(0, min($afectados, 20)) : 0;
                $evacuados  = $afectados ? rand(0, min($afectados - $fallecidos, 30)) : 0;

                SectorPecuario::create([
                    'catalogo_id'               => $especie->id,
                    'formulario_id'             => $formulario->id,
                    'numero_animales_afectados' => $afectados,
                    'numero_animales_fallecidos'=> $fallecidos,
                    'numero_animales_evacuados' => $evacuados,
                    'valor_estimado_perdida'    => $afectados ? rand(1000, 500000) / 100 : null,
                ]);
            }
        }
    }
}
