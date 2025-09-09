<?php

namespace Database\Seeders;

use App\Models\FaunaSilvestre;
use App\Models\Formulario;
use App\Models\Catalogo;
use Illuminate\Database\Seeder;

class FaunaSilvestreSeeder extends Seeder
{
    public function run(): void
    {
        $formularios = Formulario::all();
        $faunas      = Catalogo::where('tipo', 'tipo_fauna')->get();

        foreach ($formularios as $formulario) {
            foreach ($faunas as $fauna) {
                $total      = rand(0, 50);
                $muertos    = $total ? rand(0, min($total, 10)) : 0;
                $afectados  = $total ? $total - $muertos : 0;

                FaunaSilvestre::create([
                    'catalogo_id'           => $fauna->id,
                    'formulario_id'         => $formulario->id,
                    'cantidad_animales'     => $total,
                    'cantidad_animales_muertos' => $muertos,
                    'cantidad_animales_afectados' => $afectados,
                ]);
            }
        }
    }
}
