<?php

namespace Database\Seeders;

use App\Models\Infraestructura;
use App\Models\Formulario;
use App\Models\Catalogo;
use Illuminate\Database\Seeder;

class InfraestructuraSeeder extends Seeder
{
    public function run(): void
    {
        $formularios       = Formulario::all();
        $tiposInfra        = Catalogo::where('tipo', 'tipo_infraestructura')->get();

        foreach ($formularios as $formulario) {
            foreach ($tiposInfra as $tipo) {
                $afectadas = rand(0, 10);
                $destruidas = rand(0, min($afectadas, 5));

                Infraestructura::create([
                    'catalogo_id'          => $tipo->id,
                    'formulario_id'        => $formulario->id,
                    'cantidad_afectadas'   => $afectadas,
                    'cantidad_destruidas'  => $destruidas,
                    'valor_estimado_perdida' => $afectadas ? rand(1000, 50000) / 100 : null,
                    'descripcion_dano'     => fake()->optional()->sentence(),
                ]);
            }
        }
    }
}
