<?php

namespace Database\Seeders;

use App\Models\Asistencia;
use App\Models\Formulario;
use App\Models\Catalogo;
use Illuminate\Database\Seeder;

class AsistenciaSeeder extends Seeder
{
    public function run(): void
    {
        $formularios   = Formulario::all();
        $tiposAyuda    = Catalogo::where('tipo', 'tipo_asistencia')->get();

        foreach ($formularios as $formulario) {
            foreach ($tiposAyuda as $tipo) {
                Asistencia::create([
                    'actividades'            => fake()->optional()->sentence(),
                    'cantidad_beneficiarios' => rand(0, 200),
                    'fecha_asistencia'       => fake()->optional()->dateTimeBetween('-1 year', 'now'),
                    'organizacion_proveedora'=> fake()->optional()->company(),
                    'tipo_asistencia_id'     => $tipo->id,
                    'valor_asistencia'       => fake()->optional()->randomFloat(2, 100, 50000),
                    'formulario_id'          => $formulario->id,
                ]);
            }
        }
    }
}
