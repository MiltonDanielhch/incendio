<?php

namespace Database\Seeders;

use App\Models\Reforestacion;
use App\Models\Formulario;
use App\Models\Catalogo;
use Illuminate\Database\Seeder;

class ReforestacionSeeder extends Seeder
{
    public function run(): void
    {
        $formularios = Formulario::all();
        $especies    = Catalogo::where('tipo', 'especie_forestal')->get();

        foreach ($formularios as $formulario) {
            foreach ($especies as $especie) {
                $plantines   = rand(0, 5000);
                $area        = $plantines ? fake()->randomFloat(2, 0.5, 50) : null;
                $fecha       = $plantines ? fake()->dateTimeBetween('-2 years', 'now') : null;
                $supervivencia = $plantines ? fake()->randomFloat(2, 60, 98) : null;

                Reforestacion::create([
                    'catalogo_id'                  => $especie->id,
                    'formulario_id'                => $formulario->id,
                    'cantidad_plantines'           => $plantines,
                    'area_reforestada_ha'          => $area,
                    'fecha_reforestacion'          => $fecha,
                    'supervivencia_estimada_porcentaje' => $supervivencia,
                ]);
            }
        }
    }
}
