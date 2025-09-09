<?php

namespace Database\Seeders;

use App\Models\SectorAgricola;
use App\Models\Formulario;
use App\Models\Catalogo;
use Illuminate\Database\Seeder;

class SectorAgricolaSeeder extends Seeder
{
    public function run(): void
    {
        $formularios = Formulario::all();
        $cultivos    = Catalogo::where('tipo', 'tipo_cultivo')->get();

        foreach ($formularios as $formulario) {
            foreach ($cultivos as $cultivo) {
                $afectadas = fake()->randomFloat(2, 0, 150);
                $perdidas  = $afectadas > 0 ? fake()->randomFloat(2, 0, $afectadas) : 0;

                SectorAgricola::create([
                    'catalogo_id'        => $cultivo->id,
                    'formulario_id'      => $formulario->id,
                    'ha_afectadas'       => $afectadas,
                    'ha_perdidas'        => $perdidas,
                    'produccion_estimada_kg' => $afectadas > 0 ? fake()->randomFloat(2, 1000, 50000) : null,
                    'valor_estimado_perdida' => $perdidas > 0 ? fake()->randomFloat(2, 500, 100000) : null,
                ]);
            }
        }
    }
}
