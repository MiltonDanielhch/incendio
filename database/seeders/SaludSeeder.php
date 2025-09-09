<?php

namespace Database\Seeders;

use App\Models\Salud;
use App\Models\Formulario;
use App\Models\GrupoEtario;
use App\Models\Catalogo;
use Illuminate\Database\Seeder;

class SaludSeeder extends Seeder
{
    public function run(): void
    {
        $formularios = Formulario::all();
        $grupos      = GrupoEtario::all();
        // solo enfermedades/condiciones
        $enfermedades = Catalogo::where('tipo', 'enfermedad')->get();

        foreach ($formularios as $formulario) {
            foreach ($grupos as $grupo) {
                foreach ($enfermedades as $enf) {
                    Salud::create([
                        'grupo_etario_id'     => $grupo->id,
                        'catalogo_id'         => $enf->id,
                        'formulario_id'       => $formulario->id,
                        'cantidad_enfermos'   => rand(0, 15),
                        'gravedad_promedio'   => rand(1, 5),
                        'tratamiento_requerido' => fake()->optional()->sentence(),
                    ]);
                }
            }
        }
    }
}
