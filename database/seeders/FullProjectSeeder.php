<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FullProjectSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CatalogoSeeder::class,
            UbicacionSeeder::class,
            ProvinciaSeeder::class,
            MunicipioSeeder::class,
            ComunidadSeeder::class,
            GrupoEtarioSeeder::class,

            IncendioSeeder::class,
            FormularioSeeder::class,

            AfectadosIncendioSeeder::class,
            SaludSeeder::class,
            EducacionSeeder::class,
            InfraestructuraSeeder::class,
            ServicioBasicoSeeder::class,
            SectorPecuarioSeeder::class,
            SectorAgricolaSeeder::class,
            AreaForestalSeeder::class,
            FaunaSilvestreSeeder::class,
            ReforestacionSeeder::class,
            AsistenciaSeeder::class,
            AuditoriaSeeder::class,
        ]);
    }
}
