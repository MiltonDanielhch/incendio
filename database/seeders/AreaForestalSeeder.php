<?php

namespace Database\Seeders;

use App\Models\AreaForestal;
use App\Models\Formulario;
use App\Models\Catalogo;
use Illuminate\Database\Seeder;

class AreaForestalSeeder extends Seeder
{
    public function run(): void
    {
        $formularios = Formulario::all();
        $areas       = Catalogo::where('tipo', 'especie_forestal')->get();

        foreach ($formularios as $formulario) {
            foreach ($areas as $area) {
                $afectadas = fake()->randomFloat(2, 0, 200);
                $perdidas  = $afectadas > 0 ? fake()->randomFloat(2, 0, $afectadas) : 0;

                AreaForestal::create([
                    'catalogo_id'                => $area->id,
                    'formulario_id'              => $formulario->id,
                    'ha_afectadas'               => $afectadas,
                    'ha_perdidas'                => $perdidas,
                    'valor_estimado_perdida'     => $perdidas > 0 ? fake()->randomFloat(2, 1000, 500000) : null,
                    'tiempo_recuperacion_estimado_anos' => $perdidas > 0 ? rand(1, 30) : null,
                ]);
            }
        }
    }
}
