<?php

namespace Database\Seeders;

use App\Models\ServicioBasico;
use App\Models\Formulario;
use App\Models\Catalogo;
use Illuminate\Database\Seeder;

class ServicioBasicoSeeder extends Seeder
{
    public function run(): void
    {
        $formularios = Formulario::all();
        $servicios   = Catalogo::where('tipo', 'tipo_servicio')->get();

        foreach ($formularios as $formulario) {
            foreach ($servicios as $servicio) {
                $comunidades = rand(1, 5);      // comunidades afectadas
                $dias        = rand(0, 30);     // días sin servicio

                ServicioBasico::create([
                    'catalogo_id'              => $servicio->id,
                    'formulario_id'            => $formulario->id,
                    'numero_comunidades_afectadas' => $comunidades,
                    'dias_sin_servicio'        => $dias,
                    'descripcion_dano'         => fake()->optional()->sentence(),
                    'alternativas_implementadas' => fake()->optional()->sentence(),
                ]);
            }
        }
    }
}
