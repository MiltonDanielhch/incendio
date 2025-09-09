<?php

namespace Database\Seeders;

use App\Models\AfectadoIncendio;
use App\Models\Formulario;
use App\Models\GrupoEtario;
use Illuminate\Database\Seeder;

class AfectadosIncendioSeeder extends Seeder
{
    public function run(): void
    {
        $formularios = Formulario::all();
        $grupos      = GrupoEtario::all();

        foreach ($formularios as $formulario) {
            foreach ($grupos as $grupo) {
                AfectadoIncendio::create([
                    'grupo_etario_id'    => $grupo->id,
                    'formulario_id'      => $formulario->id,
                    'cantidad_afectados' => rand(0, 20),
                    'cantidad_fallecidos'=> rand(0, 3),
                    'cantidad_lesionados'=> rand(0, 5),
                ]);
            }
        }
    }
}
