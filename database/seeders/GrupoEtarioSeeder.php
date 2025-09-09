<?php

namespace Database\Seeders;

use App\Models\GrupoEtario;
use Illuminate\Database\Seeder;

class GrupoEtarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GrupoEtario::create([
            'nombre'        => 'Niños, Niñas y Adolescentes',
            'descripcion'   => 'Personas menores de 18 años',
            'edad_minima'   => 0,
            'edad_maxima'   => 17,
        ]);

        GrupoEtario::create([
            'nombre'        => 'Hombres Adultos',
            'descripcion'   => 'Personas entre 18 y 65 años',
            'edad_minima'   => 18,
            'edad_maxima'   => 65,
        ]);

        GrupoEtario::create([
            'nombre'        => 'Mujeres Adultas',
            'descripcion'   => 'Personas entre 18 y 65 años',
            'edad_minima'   => 18,
            'edad_maxima'   => 65,
        ]);

        GrupoEtario::create([
            'nombre'        => 'Tercera Edad',
            'descripcion'   => 'Personas mayores de 65 años',
            'edad_minima'   => 66,
            'edad_maxima'   => null,   // Sin límite superior
        ]);

        GrupoEtario::create([
            'nombre'        => 'Personas con Discapacidad',
            'descripcion'   => 'Personas con discapacidad, cualquier edad',
            'edad_minima'   => null,
            'edad_maxima'   => null,
        ]);
    }
}
