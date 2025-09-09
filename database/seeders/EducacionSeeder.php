<?php

namespace Database\Seeders;

use App\Models\Educacion;
use App\Models\Formulario;
use App\Models\Catalogo;
use Illuminate\Database\Seeder;

class EducacionSeeder extends Seeder
{
    public function run(): void
    {
        $formularios   = Formulario::all();
        $instituciones = Catalogo::where('tipo', 'tipo_infraestructura')
                                 ->where('contexto', 'educacion')
                                 ->get();
        $modalidades   = Catalogo::where('tipo', 'modalidad_educacion')->get();

        foreach ($formularios as $formulario) {
            foreach ($instituciones as $inst) {
                foreach ($modalidades as $mod) {
                    Educacion::create([
                        'catalogo_id'            => $inst->id,
                        'modalidad_educacion_id' => $mod->id,
                        'formulario_id'          => $formulario->id,
                        'num_estudiantes'        => rand(0, 200),
                        'num_estudiantes_afectados' => rand(0, 50),
                        'dias_clase_perdidos'    => rand(0, 30),
                    ]);
                }
            }
        }
    }
}
